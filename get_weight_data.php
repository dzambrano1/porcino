<?php
// Include database connection
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Verify connection is PDO
    if (!($conn instanceof PDO)) {
        throw new Exception("Error: La conexión no es una instancia de PDO");
    }
    
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the type parameter from the request
    $type = isset($_GET['type']) ? $_GET['type'] : 'basic';
    
    $result = [];
    
    switch ($type) {
        case 'monthly_average':
            // Monthly average weight
            $query = "SELECT 
                        DATE_FORMAT(ph_peso_fecha, '%Y-%m') as month,
                        AVG(ph_peso_animal) as average_weight,
                        COUNT(*) as total_records,
                        MIN(ph_peso_fecha) as first_date,
                        MAX(ph_peso_fecha) as last_date
                      FROM ph_peso 
                      WHERE ph_peso_animal > 0 AND ph_peso_fecha IS NOT NULL
                      GROUP BY DATE_FORMAT(ph_peso_fecha, '%Y-%m')
                      ORDER BY ph_peso_fecha ASC";
            break;
            
        default:
            // Query to get weight data ordered by date
            $query = "SELECT                 
                        pe.ph_peso_fecha as fecha, 
                        pe.ph_peso_animal as peso,
                        p.nombre as animal_nombre,
                        pe.ph_peso_tagid as tagid,
                        UNIX_TIMESTAMP(pe.ph_peso_fecha) as timestamp_fecha
                      FROM ph_peso pe
                      LEFT JOIN porcino p ON pe.ph_peso_tagid = p.tagid 
                      ORDER BY pe.ph_peso_fecha ASC";
            break;
    }
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Fetch all records as associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}