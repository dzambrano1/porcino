<?php
require_once './pdo_conexion.php';

try {
    // Check records that have sales data but aren't marked as sold
    $potentialSalesQuery = "SELECT 
                            tagid,
                            nombre,
                            fecha_venta,
                            precio_venta,
                            peso_venta,
                            estatus
                          FROM porcino 
                          WHERE (fecha_venta IS NOT NULL 
                            OR precio_venta IS NOT NULL 
                            OR peso_venta IS NOT NULL)
                          AND estatus != 'Vendido'
                          LIMIT 10";
    
    $stmt = $conn->query($potentialSalesQuery);
    $potentialSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all possible status values
    $statusQuery = "SELECT DISTINCT estatus FROM porcino";
    $stmt = $conn->query($statusQuery);
    $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Current Status Values in Database:\n";
    print_r($statuses);
    
    echo "\nPotential Sales Records (have sales data but not marked as sold):\n";
    print_r($potentialSales);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 