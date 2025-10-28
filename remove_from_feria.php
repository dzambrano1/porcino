<?php
// Include session check
require_once 'check_session.php';
requireAdmin(); // Only admin can remove from feria

// Include database connection
require_once './pdo_conexion.php';

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if request is POST and tagid is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagid'])) {
    $tagid = $_POST['tagid'];
    
    try {
        // Database connection is already established in pdo_conexion.php
        
        // Update the animal record to set precio_venta to 0 (removing from feria)
        $update_sql = "UPDATE porcino SET precio_venta = 0, fecha_publicacion = NULL WHERE tagid = ?";
        $update_stmt = $conn->prepare($update_sql);
        if ($update_stmt->execute([$tagid])) {
            if ($update_stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "Animal removido de la feria correctamente.";
            } else {
                $response['message'] = "No se encontró el animal o ya estaba removido de la feria.";
            }
        } else {
            $response['message'] = "Error al actualizar la base de datos.";
        }
        
    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "Datos inválidos o método incorrecto.";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);