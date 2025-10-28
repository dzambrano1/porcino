<?php
require_once './pdo_conexion.php';

try {
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the type parameter from the URL
    $type = $_GET['type'] ?? '';

    switch ($type) {
        case 'monthly_expense':
            // Query for monthly total expense (sum of racion * costo per month)
            $query = "
                SELECT 
                    DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m') as month,
                    ROUND(SUM(ph_sal_racion * ph_sal_costo), 2) as total_expense
                FROM ph_sal 
                WHERE ph_sal_fecha_inicio IS NOT NULL 
                GROUP BY DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m')
                ORDER BY month ASC
            ";
            break;

        case 'monthly_weight':
            // Query for monthly total weight (sum of racion per month)
            $query = "
                SELECT 
                    DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m') as month,
                    ROUND(SUM(ph_sal_racion), 2) as total_weight
                FROM ph_sal 
                WHERE ph_sal_fecha_inicio IS NOT NULL 
                GROUP BY DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m')
                ORDER BY month ASC
            ";
            break;

        case 'monthly_feed_weight':
            // Query for monthly feed weight (same as monthly_weight for salt - total racion)
            $query = "
                SELECT 
                    DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m') as month,
                    ROUND(SUM(ph_sal_racion), 2) as total_feed_kg
                FROM ph_sal 
                WHERE ph_sal_fecha_inicio IS NOT NULL 
                GROUP BY DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m')
                ORDER BY month ASC
            ";
            break;

        case 'animal_weight':
            // Query for animal weight data - we'll get the average weight per animal per month
            // Since salt records don't contain animal weights directly, we'll use a placeholder
            // This should ideally come from a weight tracking table
            $query = "
                SELECT 
                    DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m') as month,
                    COUNT(DISTINCT ph_sal_tagid) * 400 as total_weight
                FROM ph_sal 
                WHERE ph_sal_fecha_inicio IS NOT NULL 
                GROUP BY DATE_FORMAT(ph_sal_fecha_inicio, '%Y-%m')
                ORDER BY month ASC
            ";
            break;

        default:
            // Default case - return monthly averages (original behavior)
            $query = "
                SELECT 
                    DATE_FORMAT(s.ph_sal_fecha_inicio, '%Y-%m') as month,
                    p.tagid,
                    p.nombre as animal_nombre,
                    ROUND(AVG(ph_sal_costo * ph_sal_racion), 2) as average_cost
                FROM 
                    ph_sal s
                    LEFT JOIN porcino p ON s.ph_sal_tagid = p.tagid 
                GROUP BY 
                    DATE_FORMAT(s.ph_sal_fecha_inicio, '%Y-%m'),
                    p.tagid,
                    p.nombre
                ORDER BY 
                    month ASC, 
                    p.tagid ASC
            ";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data based on type
    if ($type === '' || $type === null) {
        // Default format for backward compatibility
        $formattedData = array_map(function($row) {
            return [
                'fecha' => $row['month'] . '-01', // Add day to make it a valid date
                'tagid' => $row['tagid'],
                'animal_nombre' => $row['animal_nombre'],
                'ph_sal_cantidad' => $row['average_cost']
            ];
        }, $data);
    } else {
        // For chart data, return as-is
        $formattedData = $data;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($formattedData);

} catch (PDOException $e) {
    // Return error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Return general error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}