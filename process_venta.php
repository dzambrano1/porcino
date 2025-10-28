<?php
require_once './pdo_conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to user
ini_set('log_errors', 1);

// Log the incoming request for debugging
error_log("process_venta.php called with: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['precio'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $tagid = trim($_POST['tagid']); // Remove any whitespace
            $precio = $_POST['precio'];
            $peso = $_POST['peso'];
            $fecha = $_POST['fecha'];
            
            // First, check if the animal exists and is available for sale
            $checkStmt = $conn->prepare("SELECT id, tagid, estatus FROM porcino WHERE tagid = ?");
            $checkStmt->execute([$tagid]);
            $animal = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$animal) {
                error_log("Animal not found for insert with tagid: '" . $tagid . "'");
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el animal con el Tag ID: ' . $tagid
                );
            } elseif ($animal['estatus'] === 'Vendido') {
                $response = array(
                    'success' => false,
                    'message' => 'El animal con Tag ID ' . $tagid . ' ya está marcado como vendido'
                );
            } else {
                // Animal exists and is available, register the sale
                $stmt = $conn->prepare("UPDATE porcino SET 
                    precio_venta = ?, 
                    peso_venta = ?, 
                    fecha_venta = ?,
                    estatus = 'Vendido'
                    WHERE tagid = ?");
                
                $stmt->execute([$precio, $peso, $fecha, $tagid]);
                
                // Check if update affected any rows
                if ($stmt->rowCount() > 0) {
                    $response = array(
                        'success' => true,
                        'message' => 'Venta registrada correctamente',
                        'redirect' => 'porcino_register_venta.php'
                    );
                } else {
                    error_log("INSERT UPDATE query affected 0 rows for tagid: '" . $tagid . "'");
                    $response = array(
                        'success' => false,
                        'message' => 'No se pudo registrar la venta. Inténtelo nuevamente.'
                    );
                }
            }
            
        } catch (PDOException $e) {
            error_log("PDO Exception in insert: " . $e->getMessage());
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
                // Clear sale information from porcino table
                $stmt = $conn->prepare("UPDATE porcino SET 
                    precio_venta = NULL, 
                    peso_venta = NULL, 
                    fecha_venta = NULL,
                    estatus = 'Activo'
                    WHERE id = ?");
                    
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    $response = array(
                        'success' => true,
                        'message' => 'Registro de venta eliminado correctamente',
                        'redirect' => 'porcino_register_venta.php'
                    );
                } else {
                    error_log("DELETE UPDATE query affected 0 rows for id: " . $id);
                    $response = array(
                        'success' => false,
                        'message' => 'No se pudo eliminar el registro de venta. Inténtelo nuevamente.'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['tagid'], $_POST['precio'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $tagid = trim($_POST['tagid']); // Remove any whitespace
            $precio = floatval($_POST['precio']); // Ensure it's a float
            $peso = floatval($_POST['peso']); // Ensure it's a float
            $fecha = $_POST['fecha'];
            
            // Validate input data
            if (empty($tagid)) {
                $response = array('success' => false, 'message' => 'Tag ID no puede estar vacío');
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            if ($precio <= 0) {
                $response = array('success' => false, 'message' => 'El precio debe ser mayor a 0');
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            if ($peso <= 0) {
                $response = array('success' => false, 'message' => 'El peso debe ser mayor a 0');
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            if (empty($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                $response = array('success' => false, 'message' => 'La fecha debe tener formato válido (YYYY-MM-DD)');
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            
            error_log("Validated input data: tagid='$tagid', precio=$precio, peso=$peso, fecha='$fecha'");
            
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
                // Animal exists, now update the sale information
                error_log("Animal found: ID=" . $animal['id'] . ", TagID='" . $animal['tagid'] . "', Status='" . $animal['estatus'] . "'");
                error_log("Update values: precio=$precio, peso=$peso, fecha=$fecha, tagid='$tagid'");
                
                // Get current values before update for comparison
                $beforeStmt = $conn->prepare("SELECT precio_venta, peso_venta, fecha_venta FROM porcino WHERE tagid = ?");
                $beforeStmt->execute([$tagid]);
                $beforeValues = $beforeStmt->fetch(PDO::FETCH_ASSOC);
                error_log("Current values before update: " . print_r($beforeValues, true));
                
                $stmt = $conn->prepare("UPDATE porcino SET 
                    precio_venta = ?, 
                    peso_venta = ?, 
                    fecha_venta = ?
                    WHERE tagid = ?");
                    
                $stmt->execute([$precio, $peso, $fecha, $tagid]);
                $rowsAffected = $stmt->rowCount();
                
                error_log("UPDATE query executed. Rows affected: " . $rowsAffected);
                
                if ($rowsAffected > 0) {
                    // Verify the update actually happened
                    $afterStmt = $conn->prepare("SELECT precio_venta, peso_venta, fecha_venta FROM porcino WHERE tagid = ?");
                    $afterStmt->execute([$tagid]);
                    $afterValues = $afterStmt->fetch(PDO::FETCH_ASSOC);
                    error_log("Values after update: " . print_r($afterValues, true));
                    
                    $response = array(
                        'success' => true,
                        'message' => 'Información de venta actualizada correctamente',
                        'redirect' => 'porcino_register_venta.php'
                    );
                } else {
                    // Check if the values are already the same (no change needed)
                    if ($beforeValues && 
                        $beforeValues['precio_venta'] == $precio && 
                        $beforeValues['peso_venta'] == $peso && 
                        $beforeValues['fecha_venta'] == $fecha) {
                        error_log("No update needed - values are already the same");
                        $response = array(
                            'success' => true,
                            'message' => 'La información ya estaba actualizada',
                            'redirect' => 'porcino_register_venta.php'
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
                            'message' => 'No se pudo actualizar la información de venta. Posible problema de base de datos. Contacte al administrador.'
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
    } else {
        $response = array(
            'success' => false,
            'message' => 'Acción no válida o datos no proporcionados'
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If we get here, something went wrong
header('Content-Type: application/json');
echo json_encode(array(
    'success' => false,
    'message' => 'Solicitud no válida'
));