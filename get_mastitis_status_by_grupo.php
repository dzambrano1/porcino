<?php
// Include database connection
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Verify connection is PDO
    if (!($conn instanceof PDO)) {
        throw new Exception("Error: La conexión no es una instancia de PDO");
    }
    
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $result = [];
    
    // Since mastitis only applies to "Lactando" group, we only query that group
    $grupo = 'Lactando';
    
    // Count vaccinated animals in the group
    $vaccinatedQuery = "SELECT 
                            COUNT(DISTINCT a.ph_mastitis_tagid) AS vaccinated_animals
                        FROM porcino p 
                        LEFT JOIN ph_mastitis a ON p.tagid = a.ph_mastitis_tagid
                        WHERE p.grupo = ? AND a.ph_mastitis_tagid IS NOT NULL";
    
    $stmt = $conn->prepare($vaccinatedQuery);
    $stmt->execute([$grupo]);
    $vaccinatedResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $vaccinated = $vaccinatedResult['vaccinated_animals'] ?? 0;
    
    // Count total animals in the group
    $totalQuery = "SELECT COUNT(*) AS total_animals FROM porcino WHERE grupo = ?";
    $stmt = $conn->prepare($totalQuery);
    $stmt->execute([$grupo]);
    $totalResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $totalResult['total_animals'] ?? 0;
    
    // Calculate non-vaccinated
    $nonVaccinated = $total - $vaccinated;
    
    // Get list of non-vaccinated animals for display
    $nonVaccinatedListQuery = "SELECT p.tagid, p.nombre 
                               FROM porcino p 
                               LEFT JOIN ph_mastitis a ON p.tagid = a.ph_mastitis_tagid
                               WHERE p.grupo = ? AND a.ph_mastitis_tagid IS NULL
                               ORDER BY p.nombre ASC";
    
    $stmt = $conn->prepare($nonVaccinatedListQuery);
    $stmt->execute([$grupo]);
    $nonVaccinatedList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Store the data for this group
    $result[$grupo] = [
        'vaccinated' => $vaccinated,
        'non_vaccinated' => $nonVaccinated,
        'non_vaccinated_list' => $nonVaccinatedList
    ];
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
} 