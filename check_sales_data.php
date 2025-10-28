<?php
require_once './pdo_conexion.php';

try {
    // Check total records
    $totalQuery = "SELECT COUNT(*) as total FROM porcino";
    $stmt = $conn->query($totalQuery);
    $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Check sales records
    $salesQuery = "SELECT COUNT(*) as total_sales FROM porcino WHERE estatus = 'Vendido'";
    $stmt = $conn->query($salesQuery);
    $totalSales = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];
    
    // Check records with complete sales data
    $completeSalesQuery = "SELECT COUNT(*) as complete_sales 
                          FROM porcino 
                          WHERE estatus = 'Vendido' 
                          AND fecha_venta IS NOT NULL 
                          AND precio_venta IS NOT NULL 
                          AND peso_venta IS NOT NULL";
    $stmt = $conn->query($completeSalesQuery);
    $completeSales = $stmt->fetch(PDO::FETCH_ASSOC)['complete_sales'];
    
    // Get sample of sales records
    $sampleQuery = "SELECT tagid, fecha_venta, precio_venta, peso_venta, estatus 
                   FROM porcino 
                   WHERE estatus = 'Vendido' 
                   LIMIT 5";
    $stmt = $conn->query($sampleQuery);
    $sampleRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output results
    echo "Database Analysis Results:\n";
    echo "Total Records: " . $totalRecords . "\n";
    echo "Total Sales Records: " . $totalSales . "\n";
    echo "Complete Sales Records: " . $completeSales . "\n";
    echo "\nSample Records:\n";
    print_r($sampleRecords);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 