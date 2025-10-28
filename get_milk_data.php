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
    
    // Query to get weight data ordered by date
    $query = "SELECT                 
                ph_leche_fecha as fecha, 
                ph_leche_peso as peso,
                p.nombre as animal_nombre,
                ph_leche_tagid as tagid,
                UNIX_TIMESTAMP(ph_leche_fecha) as timestamp_fecha
              FROM ph_leche l
              LEFT JOIN porcino p ON l.ph_leche_tagid = p.tagid 
              ORDER BY l.ph_leche_fecha ASC";
    
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