<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['racion'], $_POST['producto'], $_POST['etapa'], $_POST['costo'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
        try {
            // Start transaction to ensure both operations succeed or fail together
            $conn->beginTransaction();
            
            // Insert into ph_sal table
            $stmt = $conn->prepare("INSERT INTO ph_sal (ph_sal_tagid, ph_sal_racion, ph_sal_producto, ph_sal_etapa, ph_sal_costo, ph_sal_fecha_inicio, ph_sal_fecha_fin) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['tagid'],
                $_POST['racion'],
                $_POST['producto'],
                $_POST['etapa'],
                $_POST['costo'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin']
            ]);
            
            // Update the porcino table with the new etapa for the specific animal
            $stmt_porcino = $conn->prepare("UPDATE porcino SET etapa = ? WHERE tagid = ?");
            $stmt_porcino->execute([
                $_POST['etapa'],
                $_POST['tagid']
            ]);
            
            // Commit the transaction
            $conn->commit();
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente en ph_sal y porcino',
                'redirect' => 'porcino_register_sal.php'
            );
            
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $stmt = $conn->prepare("DELETE FROM ph_sal WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'porcino_register_sal.php'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el registro a eliminar'
                );
            }
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'update' && isset($_POST['id'], $_POST['racion'], $_POST['producto'], $_POST['etapa'], $_POST['costo'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
        try {
            // Start transaction to ensure both updates succeed or fail together
            $conn->beginTransaction();
            
            // First, update the ph_sal table
            $stmt = $conn->prepare("UPDATE ph_sal SET ph_sal_racion = ?, ph_sal_producto = ?, ph_sal_etapa = ?, ph_sal_costo = ?, ph_sal_fecha_inicio = ?, ph_sal_fecha_fin = ? WHERE id = ?");
            $stmt->execute([
                $_POST['racion'],
                $_POST['producto'],
                $_POST['etapa'],
                $_POST['costo'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin'],
                $_POST['id']
            ]);
            
            // Then, update the porcino table with the new etapa for the specific animal
            $stmt_porcino = $conn->prepare("UPDATE porcino SET etapa = ? WHERE tagid = ?");
            $stmt_porcino->execute([
                $_POST['etapa'],
                $_POST['tagid']
            ]);
            
            // Commit the transaction
            $conn->commit();
            
            $response = array(
                'success' => true,
                'message' => 'Registro actualizado correctamente en ph_sal y porcino',
                'redirect' => 'porcino_register_sal.php'
            );
            
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
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