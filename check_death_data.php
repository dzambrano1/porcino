<?php
require_once './pdo_conexion.php';

try {
    // Check total records
    $totalQuery = "SELECT COUNT(*) as total FROM porcino";
    $stmt = $conn->query($totalQuery);
    $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Check death records
    $deathQuery = "SELECT COUNT(*) as total_deaths FROM porcino WHERE estatus = 'Muerto'";
    $stmt = $conn->query($deathQuery);
    $totalDeaths = $stmt->fetch(PDO::FETCH_ASSOC)['total_deaths'];
    
    // Check records with complete death data
    $completeDeathQuery = "SELECT COUNT(*) as complete_deaths 
                          FROM porcino 
                          WHERE estatus = 'Muerto' 
                          AND fecha_muerte IS NOT NULL";
    $stmt = $conn->query($completeDeathQuery);
    $completeDeaths = $stmt->fetch(PDO::FETCH_ASSOC)['complete_deaths'];
    
    // Get all possible status values
    $statusQuery = "SELECT DISTINCT estatus FROM porcino";
    $stmt = $conn->query($statusQuery);
    $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get sample of death records
    $sampleQuery = "SELECT tagid, nombre, fecha_muerte, causa_muerte, estatus 
                   FROM porcino 
                   WHERE estatus = 'Muerto' 
                   LIMIT 5";
    $stmt = $conn->query($sampleQuery);
    $sampleRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check for records with death date but wrong status
    $wrongStatusQuery = "SELECT tagid, nombre, fecha_muerte, causa_muerte, estatus 
                        FROM porcino 
                        WHERE fecha_muerte IS NOT NULL 
                        AND estatus != 'Muerto'
                        LIMIT 5";
    $stmt = $conn->query($wrongStatusQuery);
    $wrongStatusRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output results
    echo "Database Analysis Results:\n";
    echo "Total Records: " . $totalRecords . "\n";
    echo "Total Death Records: " . $totalDeaths . "\n";
    echo "Complete Death Records: " . $completeDeaths . "\n";
    echo "\nCurrent Status Values in Database:\n";
    print_r($statuses);
    echo "\nSample Death Records:\n";
    print_r($sampleRecords);
    echo "\nRecords with Death Date but Wrong Status:\n";
    print_r($wrongStatusRecords);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 