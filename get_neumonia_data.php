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
    
    // Query to get neumonia data ordered by date
    $query = "SELECT         
                ph_neumonia_fecha as fecha, 
                ph_neumonia_dosis as dosis,
                ph_neumonia_costo as costo,
                ph_neumonia_producto as vacuna,
                p.nombre as animal_nombre,
                ph_neumonia_tagid as tagid
              FROM ph_neumonia
              LEFT JOIN porcino p ON ph_neumonia_tagid = p.tagid 
              ORDER BY ph_neumonia_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
} 