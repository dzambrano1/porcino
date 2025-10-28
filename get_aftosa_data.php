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
    
    // Query to get aftosa data ordered by date
    $query = "SELECT         
                ph_aftosa_fecha as fecha, 
                ph_aftosa_dosis as dosis,
                ph_aftosa_costo as costo,
                ph_aftosa_producto as vacuna,
                p.nombre as animal_nombre,
                ph_aftosa_tagid as tagid
              FROM ph_aftosa
              LEFT JOIN porcino p ON ph_aftosa_tagid = p.tagid 
              ORDER BY ph_aftosa_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
} 