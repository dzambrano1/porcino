<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['leche'], $_POST['precio'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO ph_leche (ph_leche_tagid, ph_leche_peso, ph_leche_precio, ph_leche_fecha) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $_POST['tagid'],
                $_POST['leche'],
                $_POST['precio'],
                $_POST['fecha']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente',
                'redirect' => 'porcino_historial.php'
            );
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $stmt = $conn->prepare("DELETE FROM ph_leche WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'porcino_registrar_leche.php'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['id'], $_POST['leche'], $_POST['precio'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("UPDATE ph_leche SET ph_leche_peso = ?, ph_leche_precio = ?, ph_leche_fecha = ? WHERE id = ?");
            $result = $stmt->execute([
                $_POST['leche'],
                $_POST['precio'],
                $_POST['fecha'],
                $_POST['id']
            ]);
            
            if ($result) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro actualizado correctamente',
                    'redirect' => 'porcino_registrar_leche.php'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al actualizar el registro'
                );
            }
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Datos incompletos'
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