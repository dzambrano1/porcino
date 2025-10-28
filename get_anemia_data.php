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
    
    // Query to get anemia data ordered by date
    $query = "SELECT
                ph_anemia_fecha as fecha,
                ph_anemia_dosis as dosis,
                ph_anemia_costo as costo,
                ph_anemia_producto as vacuna,
                v.nombre as animal_nombre,
                ph_anemia_tagid as tagid
              FROM ph_anemia
              LEFT JOIN porcino v ON ph_anemia_tagid = v.tagid
              ORDER BY ph_anemia_fecha DESC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
