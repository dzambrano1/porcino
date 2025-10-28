<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Enable error reporting in PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get monthly sales data from porcino table
    // Group by year and month, calculate total revenue
    $query = "SELECT 
                YEAR(fecha_venta) AS year,
                MONTH(fecha_venta) AS month,
                SUM(peso_venta * precio_venta) AS total_revenue,
                COUNT(*) AS total_sales,
                SUM(peso_venta) as total_weight,
                AVG(precio_venta) as avg_price
              FROM porcino
              WHERE 
                fecha_venta IS NOT NULL AND 
                precio_venta IS NOT NULL AND 
                peso_venta IS NOT NULL AND
                estatus = 'Vendido'
              GROUP BY YEAR(fecha_venta), MONTH(fecha_venta)
              ORDER BY year ASC, month ASC";

    // Debug: Log the query
    error_log("Sales Query: " . $query);
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Log the results
    error_log("Query Results: " . print_r($results, true));
    
    // Check if we have any data
    if (empty($results)) {
        error_log("No sales data found in the database");
    }
    
    echo json_encode($results);
} catch (PDOException $e) {
    // Return error message
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}