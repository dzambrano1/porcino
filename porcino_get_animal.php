<?php
require_once './pdo_conexion.php';

// Database connection is already established in pdo_conexion.php

// Check if ID is provided
if (!isset($_GET['id'])) {
    die(json_encode([
        'success' => false,
        'message' => 'No ID provided'
    ]));
}

// Sanitize the input
$id = $_GET['id'];

// Prepare and execute query
$sql = "SELECT * FROM porcino WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    // Fetch the data
    $animal = $result[0];
        
        // Convert any NULL values to empty strings to avoid JSON issues
        foreach ($animal as $key => $value) {
            if ($value === null) {
                $animal[$key] = '';
            }
        }

        // Format dates to Y-m-d format for HTML date inputs
        $dateFields = [
            'nacimiento', 'peso_fecha', 'racion_fecha', 'vacuna_fecha', 'bano_fecha',
            'parasitos_fecha', 'destete_fecha', 'prenez_fecha', 'parto_fecha', 'inseminacion_fecha'
        ];
        foreach ($dateFields as $field) {
            if (!empty($animal[$field])) {
                $animal[$field] = date('Y-m-d', strtotime($animal[$field]));
            }
        }

    // Return the data as JSON
    echo json_encode($animal);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No animal found with the provided ID'
    ]);
}
?> 