<?php
// Enable error logging but not display
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

require_once './pdo_conexion.php';

// Log the incoming request for debugging
error_log("process_deceso.php called with: " . print_r($_POST, true));

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'update' && isset($_POST['tagid'], $_POST['causa'], $_POST['fecha'])) {
        try {
            $tagid = trim($_POST['tagid']); // Remove any whitespace
            $causa = trim($_POST['causa']); // Remove any whitespace
            $fecha = $_POST['fecha'];
            
            // Validate input data
            if (empty($tagid)) {
                $response = array('success' => false, 'message' => 'Tag ID no puede estar vacío');
                echo json_encode($response);
                exit;
            }
            if (empty($causa)) {
                $response = array('success' => false, 'message' => 'La causa no puede estar vacía');
                echo json_encode($response);
                exit;
            }
            if (empty($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                $response = array('success' => false, 'message' => 'La fecha debe tener formato válido (YYYY-MM-DD)');
                echo json_encode($response);
                exit;
            }
            
            error_log("Validated input data: tagid='$tagid', causa='$causa', fecha='$fecha'");
            
            // First, check if the animal exists
            $checkStmt = $conn->prepare("SELECT id, tagid, estatus FROM porcino WHERE tagid = ?");
            $checkStmt->execute([$tagid]);
            $animal = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$animal) {
                // Log the attempted tagid for debugging
                error_log("Animal not found with tagid: '" . $tagid . "'");
                
                // Check if there are similar tagids (for debugging)
                $similarStmt = $conn->prepare("SELECT tagid FROM porcino WHERE tagid LIKE ? LIMIT 5");
                $similarStmt->execute(['%' . $tagid . '%']);
                $similar = $similarStmt->fetchAll(PDO::FETCH_COLUMN);
                
                if (!empty($similar)) {
                    error_log("Similar tagids found: " . implode(', ', $similar));
                }
                
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el animal con el Tag ID: ' . $tagid
                );
            } else {
                // Animal exists, now update the death information
                error_log("Animal found: ID=" . $animal['id'] . ", TagID='" . $animal['tagid'] . "', Status='" . $animal['estatus'] . "'");
                error_log("Update values: causa='$causa', fecha='$fecha', tagid='$tagid'");
                
                // Get current values before update for comparison
                $beforeStmt = $conn->prepare("SELECT deceso_causa, deceso_fecha, estatus FROM porcino WHERE tagid = ?");
                $beforeStmt->execute([$tagid]);
                $beforeValues = $beforeStmt->fetch(PDO::FETCH_ASSOC);
                error_log("Current values before update: " . print_r($beforeValues, true));
                
                $stmt = $conn->prepare("UPDATE porcino SET 
                    deceso_causa = ?, 
                    deceso_fecha = ?,
                    estatus = 'Muerto'
                    WHERE tagid = ?");
                
                $stmt->execute([$causa, $fecha, $tagid]);
                $rowsAffected = $stmt->rowCount();
                
                error_log("UPDATE query executed. Rows affected: " . $rowsAffected);
                
                if ($rowsAffected > 0) {
                    // Verify the update actually happened
                    $afterStmt = $conn->prepare("SELECT deceso_causa, deceso_fecha, estatus FROM porcino WHERE tagid = ?");
                    $afterStmt->execute([$tagid]);
                    $afterValues = $afterStmt->fetch(PDO::FETCH_ASSOC);
                    error_log("Values after update: " . print_r($afterValues, true));
                    
                    $response = array(
                        'success' => true,
                        'message' => 'Deceso registrado correctamente',
                        'redirect' => 'porcino_register_decesos.php'
                    );
                } else {
                    // Check if the values are already the same (no change needed)
                    if ($beforeValues && 
                        $beforeValues['deceso_causa'] == $causa && 
                        $beforeValues['deceso_fecha'] == $fecha && 
                        $beforeValues['estatus'] == 'Muerto') {
                        error_log("No update needed - values are already the same");
                        $response = array(
                            'success' => true,
                            'message' => 'La información ya estaba actualizada',
                            'redirect' => 'porcino_register_decesos.php'
                        );
                    } else {
                        error_log("UPDATE query affected 0 rows for tagid: '" . $tagid . "' - values were different");
                        error_log("Expected to update but didn't. This might be a database constraint or trigger issue.");
                        
                        // Try a direct query to see if the record still exists
                        $verifyStmt = $conn->prepare("SELECT COUNT(*) as count FROM porcino WHERE tagid = ?");
                        $verifyStmt->execute([$tagid]);
                        $count = $verifyStmt->fetch(PDO::FETCH_ASSOC)['count'];
                        error_log("Record verification: " . $count . " records found with tagid '" . $tagid . "'");
                        
                        $response = array(
                            'success' => false,
                            'message' => 'No se pudo actualizar la información del deceso. Posible problema de base de datos. Contacte al administrador.'
                        );
                    }
                }
            }
            
        } catch (PDOException $e) {
            error_log("PDO Exception in update: " . $e->getMessage());
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $id = intval($_POST['id']);
            
            // First, check if the record exists
            $checkStmt = $conn->prepare("SELECT id, tagid, estatus FROM porcino WHERE id = ?");
            $checkStmt->execute([$id]);
            $animal = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$animal) {
                error_log("Animal not found for delete with id: " . $id);
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el registro a eliminar'
                );
            } else {
                // Clear death information from porcino table and set status back to Activo
                $stmt = $conn->prepare("UPDATE porcino SET 
                    deceso_causa = NULL, 
                    deceso_fecha = NULL,
                    estatus = 'Activo'
                    WHERE id = ?");
                    
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    $response = array(
                        'success' => true,
                        'message' => 'Registro de deceso eliminado correctamente',
                        'redirect' => 'porcino_register_decesos.php'
                    );
                } else {
                    error_log("DELETE UPDATE query affected 0 rows for id: " . $id);
                    $response = array(
                        'success' => false,
                        'message' => 'No se pudo eliminar el registro de deceso. Inténtelo nuevamente.'
                    );
                }
            }
            
        } catch (PDOException $e) {
            error_log("PDO Exception in delete: " . $e->getMessage());
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Acción no válida o datos no proporcionados'
        );
    }
    
    echo json_encode($response);
    exit;
}

// If we get here, something went wrong
echo json_encode(array(
    'success' => false,
    'message' => 'Solicitud no válida'
));

