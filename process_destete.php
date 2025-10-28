<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("UPDATE porcino SET destete_peso = ?, destete_fecha = ? WHERE tagid = ?");
            $stmt->execute([
                $_POST['peso'],
                $_POST['fecha'],
                $_POST['tagid']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente',
                'redirect' => 'bufalino_register_destete.php'
            );
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['tagid'])) {
        try {
            $stmt = $conn->prepare("UPDATE porcino SET destete_peso = NULL, destete_fecha = NULL WHERE tagid = ?");
            $stmt->execute([$_POST['tagid']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'bufalino_register_destete.php'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['tagid'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("UPDATE porcino SET destete_peso = ?, destete_fecha = ? WHERE tagid = ?");
            $stmt->execute([
                $_POST['peso'],
                $_POST['fecha'],
                $_POST['tagid']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro actualizado correctamente',
                'redirect' => 'bufalino_register_destete.php'
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