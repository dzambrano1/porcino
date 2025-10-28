<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Database connection is already established in pdo_conexion.php

$data = [];

try {
    // Query to get monthly birth data with animal tag IDs
    $sql = "
        SELECT 
            DATE_FORMAT(ph_parto_fecha, '%Y-%m') AS month,
            COUNT(*) AS birth_count,
            GROUP_CONCAT(ph_parto_tagid ORDER BY ph_parto_tagid SEPARATOR ', ') AS birth_animals,
            UNIX_TIMESTAMP(MIN(ph_parto_fecha)) as month_timestamp
        FROM ph_parto 
        WHERE ph_parto_fecha IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $data[] = [
            'month' => $row['month'],
            'birth_count' => (int)$row['birth_count'],
            'birth_animals' => $row['birth_animals'] ? $row['birth_animals'] : '',
            'month_timestamp' => (int)$row['month_timestamp']
        ];
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching birth data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
}
?> 