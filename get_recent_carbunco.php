<?php
require_once './pdo_conexion.php';

header('Content-Type: application/json');

if (!isset($_GET['tagid'])) {
    echo json_encode(['success' => false, 'error' => 'No tagid provided']);
    exit;
}

$tagid = $_GET['tagid'];

try {
    $sql = "SELECT ph_carbunco_producto FROM ph_carbunco 
            WHERE ph_carbunco_tagid = ? 
            ORDER BY ph_carbunco_fecha DESC 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tagid]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true, 
        'producto' => $result ? $result['ph_carbunco_producto'] : ''
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 