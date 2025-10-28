<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php";

// Use mysqli for connection as in the previous examples
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, "utf8");

try {
    // Get total income from peso revenue (slaughter market value)
    $pesoQuery = "
        SELECT 
            SUM(max_weight_records.max_weight * max_weight_records.ph_peso_precio) AS total_income
        FROM (
            SELECT 
                p1.ph_peso_tagid,
                p1.ph_peso_fecha,
                p1.ph_peso_animal as max_weight,
                p1.ph_peso_precio
            FROM ph_peso p1
            INNER JOIN (
                SELECT 
                    ph_peso_tagid,
                    MAX(ph_peso_animal) as max_weight_value
                FROM ph_peso 
                WHERE ph_peso_animal > 0 AND ph_peso_precio > 0 AND ph_peso_fecha IS NOT NULL
                GROUP BY ph_peso_tagid
            ) p2 ON p1.ph_peso_tagid = p2.ph_peso_tagid 
                 AND p1.ph_peso_animal = p2.max_weight_value
            WHERE p1.ph_peso_animal > 0 AND p1.ph_peso_precio > 0 AND p1.ph_peso_fecha IS NOT NULL
        ) max_weight_records
    ";
    
    // Get concentrado expenses
    $concentradoQuery = "
        SELECT 
            SUM(
                ph_concentrado_racion * ph_concentrado_costo *
                GREATEST(1, LEAST(365, DATEDIFF(ph_concentrado_fecha_fin, ph_concentrado_fecha_inicio) + 1))
            ) AS total_concentrado_expense
        FROM ph_concentrado
        WHERE ph_concentrado_racion > 0 AND ph_concentrado_costo > 0
        AND ph_concentrado_fecha_inicio IS NOT NULL AND ph_concentrado_fecha_fin IS NOT NULL
        AND DATEDIFF(ph_concentrado_fecha_fin, ph_concentrado_fecha_inicio) >= 0
        AND DATEDIFF(ph_concentrado_fecha_fin, ph_concentrado_fecha_inicio) <= 365
    ";
    
    // Get melaza expenses
    $melazaQuery = "
        SELECT 
            SUM(
                ph_melaza_racion * ph_melaza_costo *
                GREATEST(1, LEAST(365, DATEDIFF(ph_melaza_fecha_fin, ph_melaza_fecha_inicio) + 1))
            ) AS total_melaza_expense
        FROM ph_melaza
        WHERE ph_melaza_racion > 0 AND ph_melaza_costo > 0
        AND ph_melaza_fecha_inicio IS NOT NULL AND ph_melaza_fecha_fin IS NOT NULL
        AND DATEDIFF(ph_melaza_fecha_fin, ph_melaza_fecha_inicio) >= 0
        AND DATEDIFF(ph_melaza_fecha_fin, ph_melaza_fecha_inicio) <= 365
    ";
    
    // Get sal expenses
    $salQuery = "
        SELECT 
            SUM(
                ph_sal_racion * ph_sal_costo *
                GREATEST(1, LEAST(365, DATEDIFF(ph_sal_fecha_fin, ph_sal_fecha_inicio) + 1))
            ) AS total_sal_expense
        FROM ph_sal
        WHERE ph_sal_racion > 0 AND ph_sal_costo > 0
        AND ph_sal_fecha_inicio IS NOT NULL AND ph_sal_fecha_fin IS NOT NULL
        AND DATEDIFF(ph_sal_fecha_fin, ph_sal_fecha_inicio) >= 0
        AND DATEDIFF(ph_sal_fecha_fin, ph_sal_fecha_inicio) <= 365
    ";
    
    // Get vaccine expenses
    $vaccineQuery = "
        SELECT 
            (SELECT COALESCE(SUM(ph_peste_dosis * ph_peste_costo), 0) FROM ph_peste WHERE ph_peste_dosis > 0 AND ph_peste_costo > 0) +
            (SELECT COALESCE(SUM(ph_aftosa_dosis * ph_aftosa_costo), 0) FROM ph_aftosa WHERE ph_aftosa_dosis > 0 AND ph_aftosa_costo > 0) +
            (SELECT COALESCE(SUM(ph_parvovirosis_dosis * ph_parvovirosis_costo), 0) FROM ph_parvovirosis WHERE ph_parvovirosis_dosis > 0 AND ph_parvovirosis_costo > 0) +
            (SELECT COALESCE(SUM(ph_leptopirosis_dosis * ph_leptopirosis_costo), 0) FROM ph_leptopirosis WHERE ph_leptopirosis_dosis > 0 AND ph_leptopirosis_costo > 0) +
            (SELECT COALESCE(SUM(ph_erisipela_dosis * ph_erisipela_costo), 0) FROM ph_erisipela WHERE ph_erisipela_dosis > 0 AND ph_erisipela_costo > 0) +
            (SELECT COALESCE(SUM(ph_carbunco_dosis * ph_carbunco_costo), 0) FROM ph_carbunco WHERE ph_carbunco_dosis > 0 AND ph_carbunco_costo > 0) +
            (SELECT COALESCE(SUM(ph_coccidiosis_dosis * ph_coccidiosis_costo), 0) FROM ph_coccidiosis WHERE ph_coccidiosis_dosis > 0 AND ph_coccidiosis_costo > 0) +
            (SELECT COALESCE(SUM(ph_neumonia_dosis * ph_neumonia_costo), 0) FROM ph_neumonia WHERE ph_neumonia_dosis > 0 AND ph_neumonia_costo > 0)
            AS total_vaccine_expense
    ";
    
    // Execute queries
    $pesoResult = mysqli_query($conn, $pesoQuery);
    $concentradoResult = mysqli_query($conn, $concentradoQuery);
    $melazaResult = mysqli_query($conn, $melazaQuery);
    $salResult = mysqli_query($conn, $salQuery);
    $vaccineResult = mysqli_query($conn, $vaccineQuery);
    
    // Get results
    $totalIncome = 0;
    $concentradoExpense = 0;
    $melazaExpense = 0;
    $salExpense = 0;
    $vaccineExpense = 0;
    
    if ($pesoResult) {
        $row = mysqli_fetch_assoc($pesoResult);
        $totalIncome = (float)($row['total_income'] ?? 0);
    }
    
    if ($concentradoResult) {
        $row = mysqli_fetch_assoc($concentradoResult);
        $concentradoExpense = (float)($row['total_concentrado_expense'] ?? 0);
    }
    
    if ($melazaResult) {
        $row = mysqli_fetch_assoc($melazaResult);
        $melazaExpense = (float)($row['total_melaza_expense'] ?? 0);
    }
    
    if ($salResult) {
        $row = mysqli_fetch_assoc($salResult);
        $salExpense = (float)($row['total_sal_expense'] ?? 0);
    }
    
    if ($vaccineResult) {
        $row = mysqli_fetch_assoc($vaccineResult);
        $vaccineExpense = (float)($row['total_vaccine_expense'] ?? 0);
    }
    
    // Calculate totals
    $totalExpenses = $concentradoExpense + $melazaExpense + $salExpense + $vaccineExpense;
    $grossProfit = $totalIncome - $totalExpenses;
    
    // Calculate percentages relative to total income
    $incomePercentage = 100.0;
    $expensesPercentage = $totalIncome > 0 ? ($totalExpenses / $totalIncome) * 100 : 0;
    $profitPercentage = $totalIncome > 0 ? ($grossProfit / $totalIncome) * 100 : 0;
    
    // Prepare response data
    $data = [
        [
            'category' => 'Ingresos Totales',
            'amount' => $totalIncome,
            'percentage' => $incomePercentage,
            'type' => 'income'
        ],
        [
            'category' => 'Gastos Totales',
            'amount' => $totalExpenses,
            'percentage' => $expensesPercentage,
            'type' => 'expense',
            'breakdown' => [
                'concentrado' => $concentradoExpense,
                'melaza' => $melazaExpense,
                'sal' => $salExpense,
                'vacunas' => $vaccineExpense
            ]
        ],
        [
            'category' => 'Ganancia Bruta',
            'amount' => $grossProfit,
            'percentage' => $profitPercentage,
            'type' => 'profit'
        ]
    ];
    
    echo json_encode($data);
    
} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching financial summary data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
