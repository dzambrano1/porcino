<?php
// Enable error logging but not display
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Set global error handler to catch any unexpected errors
set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'PHP Error: ' . $message]);
        exit;
    } else {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
});

// Check if IntlDateFormatter is available
if (!class_exists('IntlDateFormatter')) {
    // Fallback function for date formatting
    function formatMonthYear($date) {
        $months = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
            '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
            '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        return $months[$month] . ' ' . $year;
    }
}

// Function to upload PDF to ChatPDF
function uploadToChatPDF($filepath, $filename) {
    try {
        // Check if file exists and is readable
        if (!file_exists($filepath) || !is_readable($filepath)) {
            return [
                'success' => false,
                'error' => 'PDF file not found or not readable'
            ];
        }
        
        // Check file size (20MB limit for ChatPDF)
        $fileSize = filesize($filepath);
        if ($fileSize > 20 * 1024 * 1024) {
            return [
                'success' => false,
                'error' => 'File size exceeds 20MB limit'
            ];
        }
        
        // Read file content
        $fileContent = file_get_contents($filepath);
        if ($fileContent === false) {
            return [
                'success' => false,
                'error' => 'Failed to read file content'
            ];
        }
        
        // Prepare the file for upload using multipart/form-data
        $boundary = uniqid();
        $delimiter = '-------------' . $boundary;
        $postData = '--' . $delimiter . "\r\n" .
            'Content-Disposition: form-data; name="file"; filename="' . $filename . '"' . "\r\n" .
            'Content-Type: application/pdf' . "\r\n\r\n" .
            $fileContent . "\r\n" .
            '--' . $delimiter . "--\r\n";
        
        // ChatPDF API configuration
        $API_KEY = 'sec_AdQUXMlHjjhyrwud6dGCP9DFtUt8ZS7T';
        $CHATPDF_API_URL = 'https://api.chatpdf.com/v1';
        
        // Initialize cURL
        $curl = curl_init($CHATPDF_API_URL . '/sources/add-file');
        
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                'x-api-key: ' . $API_KEY,
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 60, // 60 second timeout
            CURLOPT_CONNECTTIMEOUT => 30 // 30 second connection timeout
        ]);
        
        // Execute the request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return [
                'success' => false,
                'error' => 'Curl error: ' . $error
            ];
        }
        
        curl_close($curl);
        
        // Parse response
        $responseData = json_decode($response, true);
        
        if ($httpCode !== 200) {
            $errorMessage = isset($responseData['error']) ? $responseData['error'] : 'Unknown API error';
            return [
                'success' => false,
                'error' => 'ChatPDF API error: ' . $errorMessage,
                'http_code' => $httpCode,
                'response' => $responseData
            ];
        }
        
        // Return success with sourceId
        return [
            'success' => true,
            'sourceId' => $responseData['sourceId'] ?? null,
            'response' => $responseData
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => 'Upload exception: ' . $e->getMessage()
        ];
    }
}

// Helper function to safely execute database queries
function safeQuery($conn, $sql, $tagid, $tableName, $pdf) {
    try {
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->execute([$tagid]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
                $data = array();
                foreach ($result as $row) {
                    $data[] = array($row['ph_' . $tableName . '_tagid'], $row['ph_' . $tableName . '_fecha'], $row['ph_' . $tableName . '_producto'], $row['ph_' . $tableName . '_dosis']);
                }
                $pdf->SimpleTable($header, $data);
            } else {
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->Cell(0, 5, 'No hay registros de ' . $tableName, 0, 1);
                $pdf->Ln(2);
            }
        } else {
            error_log("Failed to prepare $tableName query");
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(0, 5, 'Error al preparar consulta de ' . $tableName, 0, 1);
            $pdf->Ln(2);
        }
    } catch (Exception $e) {
        error_log("$tableName query error: " . $e->getMessage());
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 5, 'Error en consulta de ' . $tableName . ': ' . $e->getMessage(), 0, 1);
        $pdf->Ln(2);
    }
}

require_once './pdo_conexion.php';
require('./fpdf/fpdf.php'); // You might need to install FPDF library

// Check if reports directory exists, if not create it
$reportsDir = './reports';
if (!file_exists($reportsDir)) {
    mkdir($reportsDir, 0777, true);
}

// Ensure no output has been sent before
while (ob_get_level()) {
    ob_end_clean();
}
ob_start();

// Check if animal ID is provided
if (!isset($_GET['tagid']) || empty($_GET['tagid'])) {
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error: No animal ID provided']);
        exit;
    } else {
        die('Error: No animal ID provided');
    }
}

$tagid = $_GET['tagid'];

// Connect to database using PDO connection from pdo_conexion.php
try {
    error_log("Attempting to connect to database...");
    // The PDO connection is already established in pdo_conexion.php
    
    // Log successful connection
    error_log("Database connection established successfully");
    
} catch (Exception $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        exit;
    } else {
        die('Connection failed: ' . $e->getMessage());
    }
}



// Fetch animal basic info
$sql_animal = "SELECT * FROM porcino WHERE tagid = ?";
$stmt_animal = $conn->prepare($sql_animal);
if (!$stmt_animal) {
    error_log('Failed to prepare animal query');
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to prepare animal query']);
        exit;
    } else {
        die('Failed to prepare animal query');
    }
}

$stmt_animal->execute([$tagid]);
$result_animal = $stmt_animal->fetchAll(PDO::FETCH_ASSOC);

if (empty($result_animal)) {
    error_log('Animal not found with tagid: ' . $tagid);
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error: Animal not found with tagid: ' . $tagid]);
        exit;
    } else {
        die('Error: Animal not found with tagid: ' . $tagid);
    }
}

$animal = $result_animal[0];
error_log("Animal data retrieved successfully: " . $animal['nombre'] . " (" . $animal['tagid'] . ")");
error_log("Animal data details: " . print_r($animal, true));

// Create PDF
class PDF extends FPDF
{
    // Animal data to access in header
    protected $animalData;
    
    // Set animal data
    function setAnimalData($data) {
        $this->animalData = $data;
    }
    
    // Helper function to ensure proper UTF-8 encoding for searchable text
    function EncodeText($text) {
        // Handle null or empty values
        if ($text === null || $text === '') {
            return '';
        }
        
        // Convert to string if needed
        $text = (string)$text;
        
        // Remove control characters and normalize text
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
        
        // Convert text to proper encoding for FPDF
        if (mb_detect_encoding($text, 'UTF-8', true)) {
            // Text is UTF-8, convert to ISO-8859-1 for FPDF compatibility
            return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
        }
        return $text;
    }
    
    // Override Cell method to ensure proper text encoding
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        // Ensure text is properly formatted for searchability
        $txt = trim($txt); // Remove extra whitespace
        $txt = preg_replace('/\s+/', ' ', $txt); // Normalize whitespace
        parent::Cell($w, $h, $this->EncodeText($txt), $border, $ln, $align, $fill, $link);
    }
    
    // Add method to set optimal font for searchability
    function SetSearchableFont($family='Arial', $style='', $size=10) {
        $this->SetFont($family, $style, $size);
        // Ensure text rendering mode is optimal for searchability
        $this->_out('2 Tr'); // Set text rendering mode to fill (most searchable)
    }
    
    // Page header
    function Header()
    {
        // Only show header on first page
        if ($this->PageNo() == 1) {
            // Set margins and padding
            $this->SetMargins(10, 10, 10);
            
            // Draw a subtle header background
            $this->SetFillColor(240, 240, 240);
            $this->Rect(0, 0, 210, 35, 'F');
            
            // Logo with adjusted position
            try {
                if (file_exists('./images/default_image.png')) {
                    $this->Image('./images/default_image.png', 10, 6, 30);
                }
            } catch (Exception $e) {
                error_log("Failed to load logo: " . $e->getMessage());
                // Continue without logo
            }
            
            // Add current date on upper right
            $this->SetSearchableFont('Arial', '', 10);
            $this->SetTextColor(80, 80, 80); // Gray color for date
            $current_date = date('d/m/Y H:i:s');
            $this->SetXY(150, 8); // Position on upper right
            $this->Cell(50, 8, 'Fecha: ' . $current_date, 0, 0, 'R');
            
            // Add a decorative line
            $this->SetDrawColor(0, 128, 0); // Green line
            $this->Line(10, 35, 200, 35);
            
            // Main report title
            $this->SetFont('Arial', 'B', 18);
            $this->SetTextColor(0, 80, 0); // Darker green for main title
            
            $this->Ln(5);
            
            // Title section with animal name - larger, bold font
            $this->SetSearchableFont('Arial', 'B', 16);
            $this->SetTextColor(0, 100, 0); // Dark green color for title
            // Center alignment for animal name
            $nombre = isset($this->animalData['nombre']) ? $this->animalData['nombre'] : 'Unknown';
            if (function_exists('mb_strtoupper')) {
                $nombre = mb_strtoupper($nombre);
            } else {
                $nombre = strtoupper($nombre);
            }
            $this->Cell(0, 10, $nombre, 0, 1, 'C');
            
            // Tag ID in a slightly smaller font, still professional
            $this->SetSearchableFont('Arial', 'B', 12);
            $this->SetTextColor(80, 80, 80); // Gray color for tag ID
            // Center alignment for Tag ID
            $this->Cell(0, 10, 'Tag ID: ' . $this->animalData['tagid'], 0, 1, 'C');
            $this->Ln(5);
            
            // Add animal images
            if (!empty($this->animalData)) {
                // Photo section title
                $this->SetFont('Arial', 'B', 12);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(0, 5, 'CONDICION CORPORAL', 0, 1, 'C');
                $this->Ln(1);
                
                // Start position for images
                $y = 70; // Adjusted for the new title
                $imageWidth = 60;
                $spacing = 5;
                
                // Left position for first image
                $x1 = 10;
                // Left position for second image
                $x2 = $x1 + $imageWidth + $spacing;
                // Left position for third image
                $x3 = $x2 + $imageWidth + $spacing;
                
                // Add first image if exists
                if (!empty($this->animalData['image'])) {
                    $imagePath = $this->animalData['image'];
                    $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                    
                    // Paths to try
                    $pathsToTry = [
                        $imagePath,
                        './' . ltrim($imagePath, './'),
                        '../' . $imagePath
                    ];
                    
                    // Add document root path if available
                    if (isset($_SERVER['DOCUMENT_ROOT'])) {
                        $pathsToTry[] = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/');
                    }
                    
                    foreach ($pathsToTry as $path) {
                        if (file_exists($path)) {
                            try {
                                $this->Image($path, $x1, $y, $imageWidth);
                                break;
                            } catch (Exception $e) {
                                error_log("Failed to load image: $path - " . $e->getMessage());
                                continue;
                            }
                        }
                    }
                }
                
                                    // Add second image if exists
                    if (!empty($this->animalData['image2'])) {
                        $imagePath = $this->animalData['image2'];
                        $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                        
                        // Paths to try
                        $pathsToTry = [
                            $imagePath,
                            './' . ltrim($imagePath, './'),
                            '../' . $imagePath
                        ];
                        
                        // Add document root path if available
                        if (isset($_SERVER['DOCUMENT_ROOT'])) {
                            $pathsToTry[] = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/');
                        }
                        
                        foreach ($pathsToTry as $path) {
                            if (file_exists($path)) {
                                try {
                                    $this->Image($path, $x2, $y, $imageWidth);
                                    break;
                                } catch (Exception $e) {
                                    error_log("Failed to load image2: $path - " . $e->getMessage());
                                    continue;
                                }
                            }
                        }
                    }
                
                // Add third image if exists
                if (!empty($this->animalData['image3'])) {
                    $imagePath = $this->animalData['image3'];
                    $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                    
                    // Paths to try
                    $pathsToTry = [
                        $imagePath,
                        './' . ltrim($imagePath, './'),
                        '../' . $imagePath
                    ];
                    
                    // Add document root path if available
                    if (isset($_SERVER['DOCUMENT_ROOT'])) {
                        $pathsToTry[] = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/');
                    }
                    
                    foreach ($pathsToTry as $path) {
                        if (file_exists($path)) {
                            try {
                                $this->Image($path, $x3, $y, $imageWidth);
                                break;
                            } catch (Exception $e) {
                                error_log("Failed to load image3: $path - " . $e->getMessage());
                                continue;
                            }
                        }
                    }
                }
                
                // Add image captions
                $this->SetFont('Arial', 'I', 8);
                $this->SetY($y + $imageWidth + 2);
                $this->SetX($x1);
                $this->Cell($imageWidth, 10, 'Foto Principal', 0, 0, 'C');
                $this->SetX($x2);
                $this->Cell($imageWidth, 10, 'Foto Secundaria', 0, 0, 'C');
                $this->SetX($x3);
                $this->Cell($imageWidth, 10, 'Foto Adicional', 0, 0, 'C');
                
                // Add extra space after images
                $this->Ln(10);
            }
        }
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetSearchableFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Draw a circle
    function Circle($x, $y, $r, $style='D')
    {
        $this->Ellipse($x, $y, $r, $r, $style);
    }
    
    // Draw an ellipse
    function Ellipse($x, $y, $rx, $ry, $style='D')
    {
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
            
        $lx=4/3*(M_SQRT2-1)*$rx;
        $ly=4/3*(M_SQRT2-1)*$ry;
        $k=$this->k;
        $h=$this->h;
        
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x)*$k, ($h-$y)*$k,
            ($x+$lx)*$k, ($h-$y)*$k,
            ($x+$rx)*$k, ($h-$y+$ly)*$k,
            ($x+$rx)*$k, ($h-$y+$ry)*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x+$rx)*$k, ($h-$y+$ry+$ly)*$k,
            ($x+$lx)*$k, ($h-$y+$ry+$ry)*$k,
            ($x)*$k, ($h-$y+$ry+$ry)*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$lx)*$k, ($h-$y+$ry+$ry)*$k,
            ($x-$rx)*$k, ($h-$y+$ry+$ly)*$k,
            ($x-$rx)*$k, ($h-$y+$ry)*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x-$rx)*$k, ($h-$y+$ly)*$k,
            ($x-$lx)*$k, ($h-$y)*$k,
            ($x)*$k, ($h-$y)*$k,
            $op));
    }

    // Function to styled chapter titles
    function ChapterTitle($title)
    {
        // Add animal tagid and nombre to the title (except for farm-wide statistics)
        $animalInfo = '';
        if ($this->animalData && isset($this->animalData['tagid']) && isset($this->animalData['nombre'])) {
            // Don't add animal info for farm-wide statistics (any title containing "(Finca)" or distribution reports)
            if (strpos($title, '(Finca)') === false && $title !== 'Distribucion por Raza' && $title !== 'Distribucion de Animales por Grupo' && $title !== 'Indice de Conversion Alimenticia (ICA)' && $title !== 'Resumen de Vacunaciones y Tratamientos' && $title !== 'Duracion de Gestaciones' && $title !== 'Hembras Sin Registro de Gestacion' && $title !== 'Animales con mas de 365 Dias Desde Ultimo Parto' && $title !== 'ESTADISTICAS DE LA FINCA') {
                $animalInfo = ' ' . $this->animalData['tagid'] . ' (' . $this->animalData['nombre'] . ')';
            }
        }
        $fullTitle = $title . $animalInfo;
        
        $this->SetSearchableFont('Arial', 'B', 12);
        $this->SetFillColor(0, 100, 0); // Darker green
        $this->SetTextColor(255, 255, 255); // White text
        
        // Check if this is a main section title (all caps)
        if ($title == 'PRODUCCION' || $title == 'ALIMENTACION' || $title == 'SALUD' || 
            $title == 'REPRODUCCION' || $title == 'ESTADISTICAS DE LA FINCA') {
            // Main section titles - centered, larger font, more space before/after
            $this->SetSearchableFont('Arial', 'B', 14);
            $this->Ln(5); // Extra space before main sections
            $this->Cell(0, 10, $fullTitle, 0, 1, 'C', true);
            $this->Ln(5); // Extra space after main sections
        } else {
            // Regular subsection titles - left aligned
            $this->Cell(0, 8, $fullTitle, 0, 1, 'L', true);
            $this->Ln(3);
        }
        
        $this->SetTextColor(0, 0, 0); // Reset to black text
    }

    // Data table
    function DataTable($header, $data)
    {
        // Column widths
        $w = array(40, 50, 40, 50);
        
        // Header
        $this->SetSearchableFont('Arial', 'B', 10);
        $this->SetFillColor(50, 120, 50); // Darker green for header
        $this->SetTextColor(255, 255, 255); // White text for better contrast
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetTextColor(0, 0, 0); // Reset to black text for data
        
        // Data
        $this->SetSearchableFont('Arial', '', 9); // Match SimpleTable font size
        $this->SetFillColor(245, 250, 245); // Match SimpleTable fill color
        $fill = false;
        foreach ($data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($w[$i], 6, $row[$i], 1, 0, 'C', $fill); // Center align all cells
            }
            $this->Ln();
            $fill = !$fill;
        }
        $this->Ln(5);
    }
    
    // Simple table for two columns
    function SimpleTable($header, $data)
    {
        // Determine column count and adjust widths accordingly
        $columnCount = count($header);
        
        // Default column widths
        if ($columnCount == 2) {
            $w = array(60, 120); // Original 2-column layout
        } elseif ($columnCount == 3) {
            $w = array(50, 50, 80); // 3-column layout (date, value, price)
        } elseif ($columnCount == 4) {
            $w = array(40, 60, 40, 40); // 4-column layout
        } else {
            // Create automatic column widths
            $pageWidth = $this->GetPageWidth() - 20; // Adjust for margins
            $w = array_fill(0, $columnCount, $pageWidth / $columnCount);
        }
        
        // Check if this is a table that needs special formatting
        if (in_array('Precio ($/Kg)', $header) || in_array('Dosis', $header)) {
            // Special column widths for tables with price or dose fields
            if ($columnCount == 3) {
                $w = array(45, 60, 75); // Date, Weight/Product, Price/Dose
            }
        }
        
        // Header with background
        $this->SetSearchableFont('Arial', 'B', 10);
        $this->SetFillColor(50, 120, 50); // Darker green for header
        $this->SetTextColor(255, 255, 255); // White text for better contrast
        for ($i = 0; $i < $columnCount; $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetTextColor(0, 0, 0); // Reset to black text for data
        
        // Data
        $this->SetSearchableFont('Arial', '', 9); // Slightly smaller font to fit more text
        $this->SetFillColor(245, 250, 245); // Lighter green tint
        $fill = false;
        
        foreach ($data as $row) {
            // Make sure we have the right number of cells
            $rowCount = count($row);
            for ($i = 0; $i < $columnCount; $i++) {
                // If the cell exists in data, display it, otherwise display empty cell
                $cellContent = ($i < $rowCount) ? $row[$i] : '';
                
                // Center align all data cells for consistency
                $align = 'C';
                
                $this->Cell($w[$i], 6, $cellContent, 1, 0, $align, $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }
        
        // Add space after table
        $this->Ln(5);
    }
}

// Create PDF instance
try {
    error_log("About to create PDF instance...");
    $pdf = new PDF();
    error_log("PDF class instantiated successfully");
    $pdf->setAnimalData($animal);
    error_log("PDF instance created successfully");
} catch (Exception $e) {
    error_log('Failed to create PDF instance: ' . $e->getMessage());
    error_log('Exception details: ' . $e->getTraceAsString());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to create PDF instance: ' . $e->getMessage()]);
        exit;
    } else {
        die('Failed to create PDF instance: ' . $e->getMessage());
    }
}

// Set UTF-8 metadata for better searchability
try {
    $pdf->SetTitle('Reporte Veterinario - ' . $animal['nombre'] . ' (' . $animal['tagid'] . ')', true);
    $pdf->SetAuthor('Sistema Ganagram', true);
    $pdf->SetSubject('Historial Veterinario Completo', true);
    $pdf->SetKeywords('veterinario, ganado, bovino, historial, ' . $animal['tagid'] . ', ' . $animal['nombre'], true);
    $pdf->SetCreator('Ganagram - Sistema de Gestión Ganadera', true);
    error_log("PDF metadata set successfully");
} catch (Exception $e) {
    error_log('Failed to set PDF metadata: ' . $e->getMessage());
    // Continue anyway as this is not critical
}

$pdf->AliasNbPages();
try {
    error_log("About to add first PDF page...");
    $pdf->AddPage();
    error_log("First PDF page added successfully");
} catch (Exception $e) {
    error_log('Failed to add first page: ' . $e->getMessage());
    error_log('Exception details: ' . $e->getTraceAsString());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to add first page: ' . $e->getMessage()]);
        exit;
    } else {
        die('Failed to add first page: ' . $e->getMessage());
    }
}

// Basic animal information
$pdf->ChapterTitle('Datos');
$header = array('Concepto', 'Descripcion');
$data = array(
    array('Tag ID', $animal['tagid']),
    array('Nombre', $animal['nombre']),
    array('Fecha Nacimiento', $animal['fecha_nacimiento']),
    array('Genero', $animal['genero']),
    array('Raza', $animal['raza']),
    array('Etapa', $animal['etapa']),
    array('Grupo', $animal['grupo']),
    array('Estatus', $animal['estatus'])
);
$pdf->SimpleTable($header, $data);

// Peso history
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Pesos del animal');
$sql_weight = "SELECT ph_peso_tagid, ph_peso_fecha, ph_peso_animal, ph_peso_precio FROM ph_peso WHERE ph_peso_tagid = ? ORDER BY ph_peso_fecha DESC";
$stmt_weight = $conn->prepare($sql_weight);
$stmt_weight->execute([$tagid]);
$result_weight = $stmt_weight->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_weight)) {
    $header = array('Tag ID', 'Fecha', 'Peso (kg)', 'Precio ($/Kg)');
    $data = array();
    foreach ($result_weight as $row) {
        $data[] = array($row['ph_peso_tagid'], $row['ph_peso_fecha'], $row['ph_peso_animal'], $row['ph_peso_precio']);
    }
    $pdf->SimpleTable($header, $data);

} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay regisros de pesajes', 0, 1);
    $pdf->Ln(2);
}   

// Concentrado
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Concentrado del animal');
$sql_concentrado = "SELECT ph_concentrado_tagid, ph_concentrado_fecha_inicio, ph_concentrado_fecha_fin, ph_concentrado_racion, ph_concentrado_costo FROM ph_concentrado WHERE ph_concentrado_tagid = ? ORDER BY ph_concentrado_fecha_inicio DESC";
$stmt_concentrado = $conn->prepare($sql_concentrado);
$stmt_concentrado->execute([$tagid]);
$result_concentrado = $stmt_concentrado->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_concentrado)) {
    $header = array('Tag ID', 'Fecha Inicio', 'Fecha Fin', 'Consumo Concentrado Peso (kg)', 'Precio ($/Kg)');
    $data = array();
    foreach ($result_concentrado as $row) {
        $data[] = array($row['ph_concentrado_tagid'], $row['ph_concentrado_fecha_inicio'], $row['ph_concentrado_fecha_fin'], $row['ph_concentrado_racion'], $row['ph_concentrado_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de concentrado', 0, 1);
    $pdf->Ln(2);
}

// Salt
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Sal del animal');
$sql_salt = "SELECT ph_sal_tagid, ph_sal_fecha_inicio, ph_sal_racion, ph_sal_costo FROM ph_sal WHERE ph_sal_tagid = ? ORDER BY ph_sal_fecha_inicio DESC";
$stmt_salt = $conn->prepare($sql_salt);
$stmt_salt->execute([$tagid]);
$result_salt = $stmt_salt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_salt)) {
    $header = array('Tag ID', 'Fecha', 'Consumo Sal Racion (Kg)', 'Costo ($/Kg)');
    $data = array();
    foreach ($result_salt as $row) {
        $data[] = array($row['ph_sal_tagid'], $row['ph_sal_fecha_inicio'], $row['ph_sal_racion'], $row['ph_sal_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de sal', 0, 1);
    $pdf->Ln(2);
}

// Molasses
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Melaza del animal');
$sql_molasses = "SELECT ph_melaza_tagid, ph_melaza_fecha_inicio, ph_melaza_racion, ph_melaza_costo FROM ph_melaza WHERE ph_melaza_tagid = ? ORDER BY ph_melaza_fecha_inicio DESC";
$stmt_molasses = $conn->prepare($sql_molasses);
$stmt_molasses->execute([$tagid]);
$result_molasses = $stmt_molasses->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_molasses)) {
    $header = array('Tag ID', 'Fecha', 'Consumo Melaza Racion (Kg)', 'Costo ($/Kg)');
    $data = array();
    foreach ($result_molasses as $row) {
        $data[] = array($row['ph_melaza_tagid'], $row['ph_melaza_fecha_inicio'], $row['ph_melaza_racion'], $row['ph_melaza_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de melaza', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Anemia
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Anemia del animal');
$pdf->ChapterTitle('Anemia');
$sql_anemia = "SELECT ph_anemia_tagid, ph_anemia_fecha, ph_anemia_producto, ph_anemia_dosis FROM ph_anemia WHERE ph_anemia_tagid = ? ORDER BY ph_anemia_fecha DESC";
$stmt_anemia = $conn->prepare($sql_anemia);
$stmt_anemia->execute([$tagid]);
$result_anemia = $stmt_anemia->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_anemia)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_anemia as $row) {
        $data[] = array($row['ph_anemia_tagid'], $row['ph_anemia_fecha'], $row['ph_anemia_producto'], $row['ph_anemia_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion anemia', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Peste
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Peste del animal');
$pdf->ChapterTitle('Peste');
$sql_peste = "SELECT ph_peste_tagid, ph_peste_fecha, ph_peste_producto, ph_peste_dosis FROM ph_peste WHERE ph_peste_tagid = ? ORDER BY ph_peste_fecha DESC";
$stmt_peste = $conn->prepare($sql_peste);
$stmt_peste->execute([$tagid]);
$result_peste = $stmt_peste->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_peste)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_peste as $row) {
        $data[] = array($row['ph_peste_tagid'], $row['ph_peste_fecha'], $row['ph_peste_producto'], $row['ph_peste_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion peste', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Aftosa
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Aftosa del animal');
$pdf->ChapterTitle('Aftosa');
$sql_aftosa = "SELECT ph_aftosa_tagid, ph_aftosa_fecha, ph_aftosa_producto, ph_aftosa_dosis FROM ph_aftosa WHERE ph_aftosa_tagid = ? ORDER BY ph_aftosa_fecha DESC";
$stmt_aftosa = $conn->prepare($sql_aftosa);
$stmt_aftosa->execute([$tagid]);
$result_aftosa = $stmt_aftosa->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_aftosa)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_aftosa as $row) {
        $data[] = array($row['ph_aftosa_tagid'], $row['ph_aftosa_fecha'], $row['ph_aftosa_producto'], $row['ph_aftosa_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion aftosa', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Parvovirosis
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Parvovirosis del animal');
$pdf->ChapterTitle('Parvovirosis');
$sql_parvovirosis = "SELECT ph_parvovirosis_tagid, ph_parvovirosis_fecha, ph_parvovirosis_producto, ph_parvovirosis_dosis FROM ph_parvovirosis WHERE ph_parvovirosis_tagid = ? ORDER BY ph_parvovirosis_fecha DESC";
$stmt_parvovirosis = $conn->prepare($sql_parvovirosis);
$stmt_parvovirosis->execute([$tagid]);
$result_parvovirosis = $stmt_parvovirosis->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_parvovirosis)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_parvovirosis as $row) {
        $data[] = array($row['ph_parvovirosis_tagid'], $row['ph_parvovirosis_fecha'], $row['ph_parvovirosis_producto'], $row['ph_parvovirosis_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion parvovirosis', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Leptopirosis
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Leptopirosis del animal');
$pdf->ChapterTitle('Leptopirosis');
$sql_leptopirosis = "SELECT ph_leptopirosis_tagid, ph_leptopirosis_fecha, ph_leptopirosis_producto, ph_leptopirosis_dosis FROM ph_leptopirosis WHERE ph_leptopirosis_tagid = ? ORDER BY ph_leptopirosis_fecha DESC";
$stmt_leptopirosis = $conn->prepare($sql_leptopirosis);
$stmt_leptopirosis->execute([$tagid]);
$result_leptopirosis = $stmt_leptopirosis->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_leptopirosis)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_leptopirosis as $row) {
        $data[] = array($row['ph_leptopirosis_tagid'], $row['ph_leptopirosis_fecha'], $row['ph_leptopirosis_producto'], $row['ph_leptopirosis_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion leptopirosis', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Erisipela
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Erisipela del animal');
$pdf->ChapterTitle('Erisipela');
$sql_erisipela = "SELECT ph_erisipela_tagid, ph_erisipela_fecha, ph_erisipela_producto, ph_erisipela_dosis FROM ph_erisipela WHERE ph_erisipela_tagid = ? ORDER BY ph_erisipela_fecha DESC";
$stmt_erisipela = $conn->prepare($sql_erisipela);
$stmt_erisipela->execute([$tagid]); 
$result_erisipela = $stmt_erisipela->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_erisipela)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_erisipela as $row) {
        $data[] = array($row['ph_erisipela_tagid'], $row['ph_erisipela_fecha'], $row['ph_erisipela_producto'], $row['ph_erisipela_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion erisipela', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Carbunco
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Carbunco del animal');
$pdf->ChapterTitle('Carbunco');
$sql_carbunco = "SELECT ph_carbunco_tagid, ph_carbunco_fecha, ph_carbunco_producto, ph_carbunco_dosis FROM ph_carbunco WHERE ph_carbunco_tagid = ? ORDER BY ph_carbunco_fecha DESC";
$stmt_carbunco = $conn->prepare($sql_carbunco);
$stmt_carbunco->execute([$tagid]);
$result_carbunco = $stmt_carbunco->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_carbunco)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_carbunco as $row) {
        $data[] = array($row['ph_carbunco_tagid'], $row['ph_carbunco_fecha'], $row['ph_carbunco_producto'], $row['ph_carbunco_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion carbunco', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Coccidiosis
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Coccidiosis del animal');
$pdf->ChapterTitle('Coccidiosis');
$sql_coccidiosis = "SELECT ph_coccidiosis_tagid, ph_coccidiosis_fecha, ph_coccidiosis_producto, ph_coccidiosis_dosis FROM ph_coccidiosis WHERE ph_coccidiosis_tagid = ? ORDER BY ph_coccidiosis_fecha DESC";
$stmt_coccidiosis = $conn->prepare($sql_coccidiosis);
$stmt_coccidiosis->execute([$tagid]);
$result_coccidiosis = $stmt_coccidiosis->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_coccidiosis)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_coccidiosis as $row) {
        $data[] = array($row['ph_coccidiosis_tagid'], $row['ph_coccidiosis_fecha'], $row['ph_coccidiosis_producto'], $row['ph_coccidiosis_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion coccidiosis', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Neumonia
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Neumonia del animal');
$pdf->ChapterTitle('Neumonia');
$sql_neumonia = "SELECT ph_neumonia_tagid, ph_neumonia_fecha, ph_neumonia_producto, ph_neumonia_dosis FROM ph_neumonia WHERE ph_neumonia_tagid = ? ORDER BY ph_neumonia_fecha DESC";
$stmt_neumonia = $conn->prepare($sql_neumonia);
$stmt_neumonia->execute([$tagid]);
$result_neumonia = $stmt_neumonia->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_neumonia)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_neumonia as $row) {
        $data[] = array($row['ph_neumonia_tagid'], $row['ph_neumonia_fecha'], $row['ph_neumonia_producto'], $row['ph_neumonia_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion neumonia', 0, 1);
    $pdf->Ln(2);
}


// Vaccination - Garrapatas
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Garrapatas del animal');
$pdf->ChapterTitle('Garrapatas');
$sql_garrapatas = "SELECT ph_garrapatas_tagid, ph_garrapatas_fecha, ph_garrapatas_producto, ph_garrapatas_dosis FROM ph_garrapatas WHERE ph_garrapatas_tagid = ? ORDER BY ph_garrapatas_fecha DESC";
$stmt_garrapatas = $conn->prepare($sql_garrapatas);
$stmt_garrapatas->execute([$tagid]);
$result_garrapatas = $stmt_garrapatas->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_garrapatas)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_garrapatas as $row) {
        $data[] = array($row['ph_garrapatas_tagid'], $row['ph_garrapatas_fecha'], $row['ph_garrapatas_producto'], $row['ph_garrapatas_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion garrapatas', 0, 1);
    $pdf->Ln(2);
}


// Vaccination - Parasitos
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Parasitos del animal');
$pdf->ChapterTitle('Parasitos');
$sql_parasitos = "SELECT ph_parasitos_tagid, ph_parasitos_fecha, ph_parasitos_producto, ph_parasitos_dosis FROM ph_parasitos WHERE ph_parasitos_tagid = ? ORDER BY ph_parasitos_fecha DESC";
$stmt_parasitos = $conn->prepare($sql_parasitos);
$stmt_parasitos->execute([$tagid]);
$result_parasitos = $stmt_parasitos->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result_parasitos)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_parasitos as $row) {
        $data[] = array($row['ph_parasitos_tagid'], $row['ph_parasitos_fecha'], $row['ph_parasitos_producto'], $row['ph_parasitos_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion parasitos', 0, 1);
    $pdf->Ln(2);
}

// Vaccine and Treatment Expense Summary
$pdf->AddPage();
$pdf->ChapterTitle('Resumen de Gastos en Vacunas y Tratamientos');

// Define all vaccine and treatment tables
$vaccine_tables = [
    'ph_anemia' => 'Anemia',
    'ph_peste' => 'Peste',
    'ph_aftosa' => 'Aftosa',
    'ph_parvovirosis' => 'Parvovirosis',
    'ph_leptopirosis' => 'Leptopirosis',
    'ph_erisipela' => 'Erisipela',
    'ph_carbunco' => 'Carbunco',
    'ph_coccidiosis' => 'Coccidiosis',
    'ph_neumonia' => 'Neumonia',
    'ph_garrapatas' => 'Garrapatas',
    'ph_parasitos' => 'Parasitos'
];

$total_vaccine_expenses = 0;
$vaccine_summary = [];

foreach ($vaccine_tables as $table => $name) {
    try {
        // Check if table exists
        $check_table = $conn->prepare("SHOW TABLES LIKE ?");
        $check_table->execute([$table]);
        $table_exists = $check_table->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($table_exists)) {
            // Check if cost columns exist
            $check_cost = $conn->prepare("SHOW COLUMNS FROM $table LIKE '%costo%'");
            $check_cost->execute();
            $cost_exists = $check_cost->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($cost_exists)) {
                // Get total expenses for this vaccine/treatment
                $expense_sql = "SELECT 
                    COUNT(DISTINCT {$table}_tagid) as animals_treated,
                    SUM({$table}_costo * {$table}_dosis) as total_cost,
                    AVG({$table}_costo * {$table}_dosis) as avg_cost_per_treatment
                    FROM $table 
                    WHERE {$table}_costo > 0 AND {$table}_dosis > 0";
                
                $stmt_expense = $conn->prepare($expense_sql);
                $stmt_expense->execute();
                $expense_data = $stmt_expense->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($expense_data) && $expense_data[0]['total_cost'] > 0) {
                    $data = $expense_data[0];
                    $total_cost = floatval($data['total_cost']);
                    $total_vaccine_expenses += $total_cost;
                    
                    $vaccine_summary[] = [
                        'name' => $name,
                        'animals' => intval($data['animals_treated']),
                        'total_cost' => $total_cost,
                        'avg_cost' => floatval($data['avg_cost_per_treatment'])
                    ];
                }
            }
        }
    } catch (Exception $e) {
        error_log("Error calculating expenses for $table: " . $e->getMessage());
    }
}

// Display summary table
if (!empty($vaccine_summary)) {
    $header = array('Vacuna/Tratamiento', 'Animales Tratados', 'Costo Total ($)', 'Costo Promedio ($)');
    $data = array();
    
    // Sort by total cost descending
    usort($vaccine_summary, function($a, $b) {
        return $b['total_cost'] <=> $a['total_cost'];
    });
    
    foreach ($vaccine_summary as $vaccine) {
        $data[] = array(
            $vaccine['name'],
            $vaccine['animals'],
            number_format($vaccine['total_cost'], 2),
            number_format($vaccine['avg_cost'], 2)
        );
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add total summary
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, 'TOTAL GASTOS EN VACUNAS Y TRATAMIENTOS: $' . number_format($total_vaccine_expenses, 2), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    
    // Add percentage breakdown
    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'Distribucion por Porcentaje:', 0, 1);
    $pdf->SetFont('Arial', '', 9);
    
    foreach ($vaccine_summary as $vaccine) {
        $percentage = ($vaccine['total_cost'] / $total_vaccine_expenses) * 100;
        $pdf->Cell(0, 5, $vaccine['name'] . ': ' . number_format($percentage, 1) . '% ($' . number_format($vaccine['total_cost'], 2) . ')', 0, 1);
    }
    
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No se encontraron registros de gastos en vacunas y tratamientos', 0, 1);
    $pdf->Ln(2);
}

// At the end of the file:
// Clean any output buffers
while (ob_get_level()) {
    ob_end_clean();
}

if (!empty($result_garrapatas)) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)');
    $data = array();
    foreach ($result_garrapatas as $row) {
        $data[] = array($row['ph_garrapatas_tagid'], $row['ph_garrapatas_fecha'], $row['ph_garrapatas_producto'], $row['ph_garrapatas_dosis']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion garrapatas', 0, 1);
    $pdf->Ln(2);
}
// Sanitize animal name for filename (remove special characters and spaces)
$sanitized_name = preg_replace('/[^a-zA-Z0-9]/', '_', $animal['nombre']);
$sanitized_name = trim($sanitized_name, '_'); // Remove leading/trailing underscores

// Generate filename with timestamp to avoid conflicts
$filename = $sanitized_name . '_' . $tagid . '_' . date('Y-m-d_His') . '.pdf';
$filepath = __DIR__ . '/reports/' . $filename;

try {
    // Make sure reports directory exists
    $reportsDir = __DIR__ . '/reports';
    if (!file_exists($reportsDir)) {
        mkdir($reportsDir, 0777, true);
    }

    // Log the file path for debugging
    error_log("Attempting to generate PDF at: " . $filepath);
    error_log("Reports directory: " . $reportsDir);
    error_log("Directory exists: " . (file_exists($reportsDir) ? 'Yes' : 'No'));
    error_log("Directory writable: " . (is_writable($reportsDir) ? 'Yes' : 'No'));

    // First save the PDF to file
    try {
        error_log("About to output PDF to file: " . $filepath);
        $pdf->Output('F', $filepath);
        error_log("PDF output completed");
    } catch (Exception $e) {
        error_log("PDF Output Exception: " . $e->getMessage());
        throw new Exception('Failed to output PDF: ' . $e->getMessage());
    } catch (Error $e) {
        error_log("PDF Output Error: " . $e->getMessage());
        throw new Exception('Failed to output PDF: ' . $e->getMessage());
    }
    
    // Verify the file was created and is a PDF
    if (!file_exists($filepath)) {
        error_log("PDF file was not created at: " . $filepath);
        throw new Exception('Failed to create PDF file');
    }
    
    if (filesize($filepath) === 0) {
        error_log("PDF file is empty at: " . $filepath);
        unlink($filepath); // Delete empty file
        throw new Exception('Generated PDF file is empty');
    }
    
    // Log success
    error_log("PDF generated successfully: " . $filepath);
    error_log("File size: " . filesize($filepath) . " bytes");
    
    // Verify the file is readable
    if (!is_readable($filepath)) {
        error_log("Generated PDF file is not readable: " . $filepath);
        throw new Exception('Generated PDF file is not readable');
    }
    
    // Check if the share file exists
    $share_file = __DIR__ . '/porcino_share.php';
    if (!file_exists($share_file)) {
        error_log("Share file not found: " . $share_file);
        throw new Exception('Share file not found');
    }
    
    // Check if this is an AJAX request (from JavaScript)
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        // Check if we need to upload to ChatPDF
        $uploadResult = null;
        if (isset($_GET['upload_to_chatpdf']) && $_GET['upload_to_chatpdf'] === '1') {
            $uploadResult = uploadToChatPDF($filepath, $filename);
        }
        
        // Return JSON response for AJAX requests
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'filepath' => $filepath,
            'message' => 'PDF generated successfully',
            'upload_result' => $uploadResult
        ]);
        exit;
    } else {
        // Redirect for direct browser requests
        $redirect_url = 'porcino_share.php?file=' . urlencode($filename) . '&tagid=' . urlencode($tagid);
        error_log("Redirecting to: " . $redirect_url);
        
        // Ensure no output has been sent
        if (headers_sent()) {
            error_log("Headers already sent, cannot redirect");
            throw new Exception('Headers already sent, cannot redirect');
        }
        
        header('Location: ' . $redirect_url);
        exit;
    }
} catch (Exception $e) {
    // Log error
    error_log('PDF Generation Error: ' . $e->getMessage());
    error_log('Error occurred at: ' . $e->getFile() . ':' . $e->getLine());
    error_log('Stack trace: ' . $e->getTraceAsString());
    
    if (isset($filepath) && file_exists($filepath)) {
        error_log("Cleaning up failed file: " . $filepath);
        unlink($filepath); // Clean up any failed file
    }
    
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error generating PDF: ' . $e->getMessage() . '. Please try again.']);
        exit;
    } else {
        die('Error generating PDF: ' . $e->getMessage() . '. Please try again.');
    }
} catch (Error $e) {
    // Log fatal error
    error_log('PDF Generation Fatal Error: ' . $e->getMessage());
    error_log('Error occurred at: ' . $e->getFile() . ':' . $e->getLine());
    error_log('Stack trace: ' . $e->getTraceAsString());
    
    if (isset($filepath) && file_exists($filepath)) {
        error_log("Cleaning up failed file: " . $filepath);
        unlink($filepath); // Clean up any failed file
    }
    
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Fatal error generating PDF: ' . $e->getMessage() . '. Please try again.']);
        exit;
    } else {
        die('Fatal error generating PDF: ' . $e->getMessage() . '. Please try again.');
    }
}