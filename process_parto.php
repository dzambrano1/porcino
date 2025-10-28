<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['numero'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO ph_parto (ph_parto_tagid, ph_parto_numero, ph_parto_fecha) VALUES (?, ?, ?)");
            $stmt->execute([
                $_POST['tagid'],
                $_POST['numero'],
                $_POST['fecha']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente',
                'redirect' => 'porcino_register_parto.php'
            );
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $stmt = $conn->prepare("DELETE FROM ph_parto WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'porcino_register_parto.php'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['id'], $_POST['numero'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("UPDATE ph_parto SET ph_parto_numero = ?, ph_parto_fecha = ? WHERE id = ?");
            $stmt->execute([
                $_POST['numero'],
                $_POST['fecha'],
                $_POST['id']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro actualizado correctamente',
                'redirect' => 'porcino_register_parto.php'
            );
            
        } catch (PDOException $e) {
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
?>