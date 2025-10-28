<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Use mysqli for connection as in the previous examples
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, "utf8");

$data = [];

try {
    // Query to get monthly purchase data with animal tag IDs and purchase weights
    $sql = "
        SELECT 
            DATE_FORMAT(fecha_compra, '%Y-%m') AS month,
            COUNT(*) AS purchase_count,
            GROUP_CONCAT(CONCAT(tagid, ' (', peso_compra, ' kg)') ORDER BY tagid SEPARATOR ', ') AS purchased_animals,
            UNIX_TIMESTAMP(MIN(fecha_compra)) as month_timestamp
        FROM porcino 
        WHERE fecha_compra IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'purchase_count' => (int)$row['purchase_count'],
                'purchased_animals' => $row['purchased_animals'] ? $row['purchased_animals'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing purchase query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching purchase data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}