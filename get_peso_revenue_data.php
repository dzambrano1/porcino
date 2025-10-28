<?php
header('Content-Type: application/json');

// Include database connection details
require_once './pdo_conexion.php';

// Connect using mysqli (consistent with other endpoints)
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . mysqli_connect_error(), 'data' => []]);
    exit();
}

mysqli_set_charset($conn, 'utf8');

$data = [];

try {
    // Monthly slaughter market value: for each tagid, take its maximum weight record
    // (if multiple rows share the same max weight, take the latest date among them),
    // then group those values by month of that date and sum (USD).
    $sql = "
        WITH max_weight_per_tag AS (
            SELECT 
                ph_peso_tagid,
                MAX(ph_peso_animal) AS max_weight
            FROM ph_peso
            WHERE ph_peso_animal > 0 AND ph_peso_precio > 0 AND ph_peso_fecha IS NOT NULL
            GROUP BY ph_peso_tagid
        ),
        latest_date_for_max AS (
            SELECT 
                p.ph_peso_tagid,
                MAX(p.ph_peso_fecha) AS max_weight_date
            FROM ph_peso p
            INNER JOIN max_weight_per_tag mw
                ON p.ph_peso_tagid = mw.ph_peso_tagid
               AND p.ph_peso_animal = mw.max_weight
            WHERE p.ph_peso_animal > 0 AND p.ph_peso_precio > 0 AND p.ph_peso_fecha IS NOT NULL
            GROUP BY p.ph_peso_tagid
        ),
        max_records AS (
            SELECT 
                p.ph_peso_tagid,
                p.ph_peso_fecha,
                p.ph_peso_animal,
                p.ph_peso_precio
            FROM ph_peso p
            INNER JOIN max_weight_per_tag mw
                ON p.ph_peso_tagid = mw.ph_peso_tagid
               AND p.ph_peso_animal = mw.max_weight
            INNER JOIN latest_date_for_max ld
                ON p.ph_peso_tagid = ld.ph_peso_tagid
               AND p.ph_peso_fecha = ld.max_weight_date
            WHERE p.ph_peso_animal > 0 AND p.ph_peso_precio > 0 AND p.ph_peso_fecha IS NOT NULL
        )
        SELECT 
            DATE_FORMAT(mr.ph_peso_fecha, '%Y-%m') AS month,
            DATE_FORMAT(mr.ph_peso_fecha, '%M %Y') AS month_label,
            SUM(mr.ph_peso_animal * mr.ph_peso_precio) AS total_peso_value_usd,
            COUNT(*) AS total_animals,
            UNIX_TIMESTAMP(MIN(mr.ph_peso_fecha)) AS month_timestamp
        FROM max_records mr
        GROUP BY DATE_FORMAT(mr.ph_peso_fecha, '%Y-%m')
        ORDER BY mr.ph_peso_fecha ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'month_label' => $row['month_label'],
                'total_peso_value_usd' => round((float)$row['total_peso_value_usd'], 2),
                'total_animals' => (int)$row['total_animals'],
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception('Error executing peso revenue query: ' . mysqli_error($conn));
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    error_log('Error fetching peso revenue data: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Error processing request: ' . $e->getMessage(),
        'data' => []
    ]);
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>


