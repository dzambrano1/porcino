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
    // First, let's check which tables actually exist
    $tableCheckQuery = "SHOW TABLES LIKE 'ph_%'";
    $tableResult = mysqli_query($conn, $tableCheckQuery);
    $existingTables = [];
    if ($tableResult) {
        while ($row = mysqli_fetch_array($tableResult)) {
            $existingTables[] = $row[0];
        }
    }
    
    // Array of vaccine tables and their corresponding column names
    $vaccines = [
        'Peste' => ['table' => 'ph_peste', 'dosis' => 'ph_peste_dosis', 'costo' => 'ph_peste_costo'],
        'Aftosa' => ['table' => 'ph_aftosa', 'dosis' => 'ph_aftosa_dosis', 'costo' => 'ph_aftosa_costo'],
        'Parvovirosis' => ['table' => 'ph_parvovirosis', 'dosis' => 'ph_parvovirosis_dosis', 'costo' => 'ph_parvovirosis_costo'],
        'Leptopirosis' => ['table' => 'ph_leptopirosis', 'dosis' => 'ph_leptopirosis_dosis', 'costo' => 'ph_leptopirosis_costo'],
        'Erisipela' => ['table' => 'ph_erisipela', 'dosis' => 'ph_erisipela_dosis', 'costo' => 'ph_erisipela_costo'],
        'Carbunco' => ['table' => 'ph_carbunco', 'dosis' => 'ph_carbunco_dosis', 'costo' => 'ph_carbunco_costo'],
        'Coccidiosis' => ['table' => 'ph_coccidiosis', 'dosis' => 'ph_coccidiosis_dosis', 'costo' => 'ph_coccidiosis_costo'],
        'Neumonia' => ['table' => 'ph_neumonia', 'dosis' => 'ph_neumonia_dosis', 'costo' => 'ph_neumonia_costo']
    ];

    foreach ($vaccines as $vaccineName => $vaccineInfo) {
        $table = $vaccineInfo['table'];
        $dosisColumn = $vaccineInfo['dosis'];
        $costoColumn = $vaccineInfo['costo'];

        // Check if table exists
        if (!in_array($table, $existingTables)) {
            continue;
        }

        // Query to get total cost for this vaccine type
        $sql = "
            SELECT 
                SUM({$dosisColumn} * {$costoColumn}) AS total_cost
            FROM {$table} 
            WHERE {$dosisColumn} > 0 AND {$costoColumn} > 0
        ";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalCost = $row['total_cost'] ? (float)$row['total_cost'] : 0;
            

            
            $data[] = [
                'vaccine_name' => $vaccineName,
                'total_cost' => $totalCost
            ];
            
            mysqli_free_result($result);
        } else {
            // Continue with other vaccines even if one fails
            $data[] = [
                'vaccine_name' => $vaccineName,
                'total_cost' => 0
            ];
        }
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching vaccine costs data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}