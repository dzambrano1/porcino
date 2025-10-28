<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Get the action from POST data
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'insert':
            // Insert new plan salud record
            $enfermedad = $_POST['enfermedad'] ?? '';
            $vacuna = $_POST['vacuna'] ?? '';
            $dosis = $_POST['dosis'] ?? '';
            $edad_aplicacion = $_POST['edad_aplicacion'] ?? '';
            $refuerzo = $_POST['refuerzo'] ?? null;
            $costo = $_POST['costo'] ?? '';
            $observaciones = $_POST['observaciones'] ?? '';
            
            // Validate required fields
            if (empty($enfermedad) || empty($vacuna) || empty($dosis) || empty($edad_aplicacion) || empty($costo)) {
                throw new Exception('Todos los campos obligatorios deben estar completos');
            }
            
            // Prepare and execute insert query
            $query = "INSERT INTO plan_salud_porcino (enfermedad, vacuna, dosis, edad_aplicacion, refuerzo, costo, observaciones) 
                      VALUES (:enfermedad, :vacuna, :dosis, :edad_aplicacion, :refuerzo, :costo, :observaciones)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':enfermedad', $enfermedad);
            $stmt->bindParam(':vacuna', $vacuna);
            $stmt->bindParam(':dosis', $dosis);
            $stmt->bindParam(':edad_aplicacion', $edad_aplicacion);
            $stmt->bindParam(':refuerzo', $refuerzo);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':observaciones', $observaciones);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Plan de salud registrado exitosamente']);
            } else {
                throw new Exception('Error al insertar el registro');
            }
            break;
            
        case 'update':
            // Update existing plan salud record
            $id = $_POST['id'] ?? '';
            $enfermedad = $_POST['enfermedad'] ?? '';
            $vacuna = $_POST['vacuna'] ?? '';
            $dosis = $_POST['dosis'] ?? '';
            $edad_aplicacion = $_POST['edad_aplicacion'] ?? '';
            $refuerzo = $_POST['refuerzo'] ?? null;
            $costo = $_POST['costo'] ?? '';
            $observaciones = $_POST['observaciones'] ?? '';
            
            // Validate required fields
            if (empty($id) || empty($enfermedad) || empty($vacuna) || empty($dosis) || empty($edad_aplicacion) || empty($costo)) {
                throw new Exception('Todos los campos obligatorios deben estar completos');
            }
            
            // Prepare and execute update query
            $query = "UPDATE plan_salud_porcino 
                      SET enfermedad = :enfermedad, vacuna = :vacuna, dosis = :dosis, 
                          edad_aplicacion = :edad_aplicacion, refuerzo = :refuerzo, 
                          costo = :costo, observaciones = :observaciones 
                      WHERE id = :id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':enfermedad', $enfermedad);
            $stmt->bindParam(':vacuna', $vacuna);
            $stmt->bindParam(':dosis', $dosis);
            $stmt->bindParam(':edad_aplicacion', $edad_aplicacion);
            $stmt->bindParam(':refuerzo', $refuerzo);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':observaciones', $observaciones);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Plan de salud actualizado exitosamente']);
                } else {
                    throw new Exception('No se encontró el registro a actualizar');
                }
            } else {
                throw new Exception('Error al actualizar el registro');
            }
            break;
            
        case 'delete':
            // Delete plan salud record
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                throw new Exception('ID del registro es requerido');
            }
            
            // Prepare and execute delete query
            $query = "DELETE FROM plan_salud_porcino WHERE id = :id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Plan de salud eliminado exitosamente']);
                } else {
                    throw new Exception('No se encontró el registro a eliminar');
                }
            } else {
                throw new Exception('Error al eliminar el registro');
            }
            break;
            
        default:
            throw new Exception('Acción no válida');
    }
    
} catch (Exception $e) {
    // Return error response
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    // Return database error response
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
