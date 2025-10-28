<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Database connection is already established in pdo_conexion.php

$data = [];

try {
    // Query to get monthly sales data with animal tag IDs and sale weights
    $sql = "
        SELECT 
            DATE_FORMAT(fecha_venta, '%Y-%m') AS month,
            COUNT(*) AS sales_count,
            GROUP_CONCAT(CONCAT(tagid, ' (', peso_venta, ' kg)') ORDER BY tagid SEPARATOR ', ') AS sold_animals,
            UNIX_TIMESTAMP(MIN(fecha_venta)) as month_timestamp
        FROM porcino 
        WHERE fecha_venta IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $data[] = [
            'month' => $row['month'],
            'sales_count' => (int)$row['sales_count'],
            'sold_animals' => $row['sold_animals'] ? $row['sold_animals'] : '',
            'month_timestamp' => (int)$row['month_timestamp']
        ];
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching sales data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
}