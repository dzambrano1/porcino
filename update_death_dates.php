<?php
require_once './pdo_conexion.php';

try {
    // Update death dates to use 2024
    $query = "
        UPDATE porcino 
        SET deceso_fecha = DATE_FORMAT(deceso_fecha, '2024-%m-%d')
        WHERE estatus = 'Muerto' 
        AND YEAR(deceso_fecha) = 2025
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    echo "Updated " . $stmt->rowCount() . " death records\n";
    
    // Verify the update
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
    
    echo "\nUpdated Records:\n";
    foreach ($records as $record) {
        echo "Animal: {$record['nombre']} (ID: {$record['tagid']})\n";
        echo "Death Date: {$record['deceso_fecha']}\n";
        echo "Cause: {$record['deceso_causa']}\n";
        echo "Status: {$record['estatus']}\n";
        echo "----------------------------------------\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 