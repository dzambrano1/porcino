<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php";

try {
    // Query to get monthly death data with details for tooltips
    $sql = "
        SELECT 
            DATE_FORMAT(deceso_fecha, '%Y-%m') AS month,
            COUNT(*) AS deaths_count,
            GROUP_CONCAT(
                CONCAT(tagid, ' - ', deceso_causa) 
                ORDER BY deceso_fecha 
                SEPARATOR '|'
            ) AS death_details
        FROM porcino 
        WHERE estatus = 'Muerto' 
        AND deceso_fecha IS NOT NULL 
        AND deceso_fecha <= CURDATE()  -- Only include deaths up to today
        GROUP BY month 
        ORDER BY month ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for the chart
    $data = [];
    foreach ($results as $row) {
        $data[] = [
            'month' => $row['month'],
            'deaths_count' => (int)$row['deaths_count'],
            'death_details' => $row['death_details']
        ];
    }

    // If no data found, return empty array
    if (empty($data)) {
        echo json_encode([]);
        exit;
    }

    echo json_encode($data);

} catch (PDOException $e) {
    // Log error and return error message
    error_log("Error fetching deaths data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
}