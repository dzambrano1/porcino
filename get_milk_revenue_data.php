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
    // Query to get total monthly milk value from ph_leche table
    $sql = "
        SELECT 
            DATE_FORMAT(ph_leche_fecha, '%Y-%m') AS month, 
            SUM(ph_leche_peso * ph_leche_precio) AS total_milk_value,
            UNIX_TIMESTAMP(MIN(ph_leche_fecha)) as month_timestamp
        FROM ph_leche 
        WHERE ph_leche_peso > 0 AND ph_leche_precio > 0 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'total_milk_value' => (float)$row['total_milk_value'],
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing milk revenue query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching milk revenue data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?> 