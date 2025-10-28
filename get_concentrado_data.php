<?php
require_once './pdo_conexion.php';

try {
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get monthly averages of (costo × racion)
    $query = "
        SELECT 
            DATE_FORMAT(ph_concentrado_fecha_inicio, '%Y-%m') as month,
            p.tagid,
            p.nombre as animal_nombre,
            ROUND(AVG(ph_concentrado_costo * ph_concentrado_racion), 2) as average_cost
        FROM 
            ph_concentrado c
            LEFT JOIN porcino p ON c.ph_concentrado_tagid = p.tagid 
        GROUP BY 
            DATE_FORMAT(ph_concentrado_fecha_inicio, '%Y-%m'),
            p.tagid,
            p.nombre
        ORDER BY 
            month ASC, 
            p.tagid ASC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for the chart
    $formattedData = array_map(function($row) {
        return [
            'fecha' => $row['month'] . '-01', // Add day to make it a valid date
            'tagid' => $row['tagid'],
            'animal_nombre' => $row['animal_nombre'],
            'ph_concentrado_cantidad' => $row['average_cost']
        ];
    }, $data);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($formattedData);

} catch (PDOException $e) {
    // Return error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}