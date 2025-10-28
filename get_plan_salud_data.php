<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // First check if the table exists
    $checkTableQuery = "SHOW TABLES LIKE 'plan_salud_porcino'";
    $stmt = $conn->prepare($checkTableQuery);
    $stmt->execute();
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        // Create the table if it doesn't exist
        $createTableQuery = "CREATE TABLE IF NOT EXISTS `plan_salud_porcino` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `enfermedad` varchar(255) NOT NULL,
            `vacuna` varchar(255) NOT NULL,
            `dosis` decimal(10,2) NOT NULL,
            `edad_aplicacion` int(11) NOT NULL,
            `refuerzo` int(11) DEFAULT NULL,
            `costo` decimal(10,2) NOT NULL,
            `observaciones` text DEFAULT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $conn->exec($createTableQuery);
        
        // Insert some sample data
        $sampleData = [
            ['Fiebre Aftosa', 'Vacuna Aftosa Triple', 2.5, 30, 90, 15.50, 'Vacuna obligatoria para exportación'],
            ['Parvovirosis', 'Vacuna Parvo', 1.0, 21, 42, 12.75, 'Prevención de enfermedad viral'],
            ['Erisipela', 'Vacuna Erisipela', 1.5, 45, 90, 18.25, 'Protección contra bacteria'],
            ['Brucelosis', 'Vacuna Brucella', 2.0, 60, 120, 22.00, 'Vacuna para reproductores'],
            ['Carbunco', 'Vacuna Carbunco', 1.0, 90, 180, 16.50, 'Protección contra esporas']
        ];
        
        $insertQuery = "INSERT INTO plan_salud_porcino (enfermedad, vacuna, dosis, edad_aplicacion, refuerzo, costo, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        
        foreach ($sampleData as $data) {
            $stmt->execute($data);
        }
    }
    
    // Now get the data
    $planSaludQuery = "SELECT * FROM plan_salud_porcino ORDER BY edad_aplicacion ASC";
    $stmt = $conn->prepare($planSaludQuery);
    $stmt->execute();
    $planSaludData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the data as JSON
    echo json_encode([
        'success' => true,
        'data' => $planSaludData,
        'message' => 'Datos recuperados exitosamente'
    ]);
    
} catch (Exception $e) {
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage(),
        'data' => []
    ]);
} catch (PDOException $e) {
    // Return database error response
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error de base de datos: ' . $e->getMessage(),
        'data' => []
    ]);
}
?>
