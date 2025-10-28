<?php
require_once './pdo_conexion.php';

try {
    // Get all death records
    $query = "
        SELECT 
            tagid,
            nombre,
            deceso_fecha,
            deceso_causa,
            estatus
        FROM porcino 
        WHERE estatus = 'Muerto'
        ORDER BY deceso_fecha ASC
    ";
    
    $stmt = $conn->query($query);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Death Records Analysis:\n";
    echo "Current Date: " . date('Y-m-d') . "\n\n";
    
    foreach ($records as $record) {
        echo "Animal: {$record['nombre']} (ID: {$record['tagid']})\n";
        echo "Death Date: {$record['deceso_fecha']}\n";
        echo "Cause: {$record['deceso_causa']}\n";
        echo "Status: {$record['estatus']}\n";
        echo "Days from today: " . round((strtotime($record['deceso_fecha']) - strtotime('today')) / (60 * 60 * 24)) . "\n";
        echo "----------------------------------------\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 