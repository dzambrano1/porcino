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
    // Query to get total monthly sal expense from ph_sal table
    // Expense = (racion * costo) * days difference (fecha_fin - fecha_inicio)
    // Use fecha_fin for monthly grouping
    $sql = "
        SELECT 
            DATE_FORMAT(ph_sal_fecha_fin, '%Y-%m') AS month, 
            SUM(
                ph_sal_racion * ph_sal_costo * 
                GREATEST(1, DATEDIFF(ph_sal_fecha_fin, ph_sal_fecha_inicio) + 1)
            ) AS total_sal_expense,
            UNIX_TIMESTAMP(MIN(ph_sal_fecha_fin)) as month_timestamp
        FROM ph_sal 
        WHERE ph_sal_racion > 0 
          AND ph_sal_costo > 0 
          AND ph_sal_fecha_inicio IS NOT NULL 
          AND ph_sal_fecha_fin IS NOT NULL
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $monthlyData = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $monthlyData[] = [
                'month' => $row['month'],
                'total_sal_expense' => (float)$row['total_sal_expense'],
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
        
        // Calculate cumulative expenses
        $cumulativeExpense = 0;
        foreach ($monthlyData as $monthData) {
            $cumulativeExpense += $monthData['total_sal_expense'];
            $data[] = [
                'month' => $monthData['month'],
                'total_sal_expense' => $monthData['total_sal_expense'],
                'cumulative_sal_expense' => $cumulativeExpense,
                'month_timestamp' => $monthData['month_timestamp']
            ];
        }
    } else {
        throw new Exception("Error executing sal expense query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching sal expense data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?> 