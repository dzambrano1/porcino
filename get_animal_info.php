<?php
require_once './pdo_conexion.php';

header('Content-Type: application/json');

// Check if tagid is provided
if (!isset($_GET['tagid']) || empty($_GET['tagid'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No se proporcionó TagID']);
    exit;
}

$tagid = $_GET['tagid'];

// Database connection is already established in pdo_conexion.php

// Prepare and execute query
$stmt = $conn->prepare("SELECT tagid, nombre FROM porcino WHERE tagid = ?");
$stmt->execute([$tagid]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {
    http_response_code(404);
    echo json_encode(['error' => 'Animal no encontrado']);
    exit;
}

// Return animal data
echo json_encode($result[0]); 