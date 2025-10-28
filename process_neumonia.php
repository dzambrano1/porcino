<?php
// Include database connection
require_once './pdo_conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set response header to JSON
header('Content-Type: application/json');

// Log incoming request for debugging
error_log("process_neumonia.php called with POST data: " . print_r($_POST, true));

// Handle different actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Check database connection
    if (!($conn instanceof PDO)) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    try {
        // INSERT operation
        if ($action === 'insert') {
            // Validate required fields
            $requiredFields = ['tagid', 'dosis', 'vacuna', 'costo', 'fecha'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Campo requerido: $field");
                }
            }
            
            // Prepare data
            $tagid = trim($_POST['tagid']);
            $dosis = floatval($_POST['dosis']);
            $vacuna = trim($_POST['vacuna']);
            $costo = floatval($_POST['costo']);
            $fecha = $_POST['fecha'];
            
            // Additional validation
            if ($dosis <= 0) {
                throw new Exception("La dosis debe ser mayor a 0");
            }
            if ($costo < 0) {
                throw new Exception("El costo no puede ser negativo");
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                throw new Exception("Formato de fecha inválido");
            }
            
            // Execute query
            $stmt = $conn->prepare("INSERT INTO ph_neumonia (ph_neumonia_tagid, ph_neumonia_producto, ph_neumonia_dosis, ph_neumonia_costo, ph_neumonia_fecha) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt->execute([$tagid, $vacuna, $dosis, $costo, $fecha])) {
                throw new Exception("Error al insertar en la base de datos: " . implode(", ", $stmt->errorInfo()));
            }
            
            echo json_encode(['success' => true, 'message' => 'Registro agregado correctamente']);
        }
        
        // UPDATE operation
        else if ($action === 'update') {
            // Validate required fields
            $requiredFields = ['id', 'tagid', 'dosis', 'vacuna', 'costo', 'fecha'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Campo requerido: $field");
                }
            }
            
            // Prepare data
            $id = intval($_POST['id']);
            $tagid = trim($_POST['tagid']);
            $dosis = floatval($_POST['dosis']);
            $vacuna = trim($_POST['vacuna']);
            $costo = floatval($_POST['costo']);
            $fecha = $_POST['fecha'];
            
            // Additional validation
            if ($id <= 0) {
                throw new Exception("ID inválido");
            }
            if ($dosis <= 0) {
                throw new Exception("La dosis debe ser mayor a 0");
            }
            if ($costo < 0) {
                throw new Exception("El costo no puede ser negativo");
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                throw new Exception("Formato de fecha inválido");
            }
            
            // Execute query
            $stmt = $conn->prepare("UPDATE ph_neumonia SET ph_neumonia_tagid = ?, ph_neumonia_producto = ?, ph_neumonia_dosis = ?, ph_neumonia_costo = ?, ph_neumonia_fecha = ? WHERE id = ?");
            if (!$stmt->execute([$tagid, $vacuna, $dosis, $costo, $fecha, $id])) {
                throw new Exception("Error al actualizar en la base de datos: " . implode(", ", $stmt->errorInfo()));
            }
            
            echo json_encode(['success' => true, 'message' => 'Registro actualizado correctamente']);
        }
        
        // DELETE operation
        else if ($action === 'delete') {
            // Validate required fields
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception("ID requerido para eliminar");
            }
            
            // Prepare data
            $id = intval($_POST['id']);
            
            // Additional validation
            if ($id <= 0) {
                throw new Exception("ID inválido");
            }
            
            // Check if record exists before deleting
            $checkStmt = $conn->prepare("SELECT id FROM ph_neumonia WHERE id = ?");
            if (!$checkStmt->execute([$id])) {
                throw new Exception("Error al verificar el registro: " . implode(", ", $checkStmt->errorInfo()));
            }
            if (!$checkStmt->fetch()) {
                throw new Exception("El registro no existe o ya fue eliminado");
            }
            
            // Execute query
            $stmt = $conn->prepare("DELETE FROM ph_neumonia WHERE id = ?");
            if (!$stmt->execute([$id])) {
                throw new Exception("Error al eliminar de la base de datos: " . implode(", ", $stmt->errorInfo()));
            }
            
            echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
        }
        
        // Invalid action
        else {
            throw new Exception("Acción inválida: $action");
        }
    } 
    catch (Exception $e) {
        // Return error message
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} 
else {
    // No action specified
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No se especificó ninguna acción']);
}
