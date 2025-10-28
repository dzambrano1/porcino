<?php
require_once './pdo_conexion.php';

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Fetch data for the chart ---
$chartLabels = [];
$chartData = [];
$chartAnimals = [];
try {
    $chartQuery = "SELECT 
                     p.tagid,
                     p.nombre,
                     p.destete_peso,
                     p.destete_fecha,
                     DATE_FORMAT(p.destete_fecha, '%y-%m') as month_year
                   FROM porcino p
                   WHERE p.destete_fecha IS NOT NULL
                     AND p.destete_fecha != '0000-00-00'
                     AND p.destete_peso IS NOT NULL
                   ORDER BY p.destete_fecha ASC";
    $chartStmt = $conn->prepare($chartQuery);
    $chartStmt->execute();
    $chartResults = $chartStmt->fetchAll(PDO::FETCH_ASSOC);

    // Group animals by month-year
    $monthlyGroups = [];
    foreach ($chartResults as $row) {
        $monthYear = $row['month_year'];
        if (!isset($monthlyGroups[$monthYear])) {
            $monthlyGroups[$monthYear] = [];
        }
        $monthlyGroups[$monthYear][] = [
            'tagid' => $row['tagid'],
            'nombre' => $row['nombre'],
            'peso' => (float)$row['destete_peso']
        ];
    }

    // Create chart data
    foreach ($monthlyGroups as $monthYear => $animals) {
        $chartLabels[] = $monthYear;
        // Use average weight for the bar height
        $totalWeight = array_sum(array_column($animals, 'peso'));
        $averageWeight = $totalWeight / count($animals);
        $chartData[] = round($averageWeight, 2);
        $chartAnimals[] = $animals; // Array of animals for this month
    }
} catch (PDOException $e) {
    error_log("Error fetching chart data: " . $e->getMessage());
    // Handle error appropriately, maybe set default values or show an error message
}

// Encode data for JavaScript
$chartLabelsJson = json_encode($chartLabels);
$chartDataJson = json_encode($chartData);
$chartAnimalsJson = json_encode($chartAnimals);
// --- End chart data fetching ---

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Porcino - Registro de Destete</title>
<!-- Link to the Favicon -->
<link rel="icon" href="images/default_image.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!--Bootstrap 5 Css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<!-- Include Chart.js and Chart.js DataLabels Plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<!-- SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<!-- Place these in the <head> section in this exact order -->

<!-- jQuery Core (main library) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add these in the <head> section, after your existing DataTables CSS/JS -->
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="./porcino.css">
</head>
<body>
<!-- Navigation Title -->
<nav class="navbar text-center" style="border: none !important; box-shadow: none !important;">
    <!-- Title Row -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-between align-items-center position-relative">
                <!-- Botón de Configuración -->
                <button type="button" onclick="window.location.href='./porcino_configuracion.php'" class="btn" style="color:white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Configuración">
                    <i class="fas fa-cog"></i> 
                </button>
                
                <!-- Título centrado -->
                <h1 class="navbar-title text-center position-absolute" style="left: 50%; transform: translateX(-50%); z-index: 1;">
                    <i class="fas fa-clipboard-list me-2"></i>LA GRANJA DE TITO<span class="ms-2"><i class="fas fa-file-medical"></i></span>
                </h1>
                
                <!-- Botón de Salir -->
                <button type="button" onclick="window.location.href='../inicio.php'" class="btn" style="color: white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i> 
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Subtitle - 3 Steps Guide -->
<style>
.arrow-step {
    position: relative;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    padding: 20px 30px;
    margin: 0 10px;
    clip-path: polygon(0% 0%, calc(100% - 30px) 0%, 100% 50%, calc(100% - 30px) 100%, 0% 100%, 30px 50%);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    min-height: 108px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0.7;
    transition: all 0.3s ease;
    cursor: pointer;
}

.arrow-step:hover:not(.arrow-step-active) {
    opacity: 0.9;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

.arrow-step-active {
    background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%) !important;
    opacity: 1 !important;
    box-shadow: 0 8px 25px rgba(32, 201, 151, 0.5) !important;
    transform: scale(1.05);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 8px 25px rgba(32, 201, 151, 0.5);
    }
    50% {
        box-shadow: 0 8px 35px rgba(32, 201, 151, 0.8);
    }
}

.arrow-step-first {
    clip-path: polygon(0% 0%, calc(100% - 30px) 0%, 100% 50%, calc(100% - 30px) 100%, 0% 100%);
    border-radius: 10px 0 0 10px;
}

.arrow-step-last {
    clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 30px 50%);
    border-radius: 0 10px 10px 0;
}

.badge-active {
    position: absolute;
    top: 10px;
    right: 20px;
    background: #ffc107;
    color: #000;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    animation: bounce 1s infinite;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

@media (max-width: 768px) {
    .arrow-step, .arrow-step-first, .arrow-step-last {
        clip-path: none !important;
        border-radius: 10px !important;
        margin: 10px 0;
    }
    .badge-active {
        right: 10px;
    }
}
</style>

<div class="container-fluid mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-11">
            <div class="row justify-content-center align-items-stretch">
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-first w-100" onclick="window.location.href='./inventario_porcino.php'" title="Ir a Inventario">
                        <div style="background: white; color: #28a745; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            1
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 1:<br>Crear Animales</h5>
                    </div>
                </div>
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-active w-100">
                        <span class="badge-active">🎯 Registrando Destetes</span>
                        <div style="background: white; color: #17a2b8; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            2
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 2:<br>Registrar Tareas</h5>
                    </div>
                </div>
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-last w-100" onclick="window.location.href='./porcino_indices.php'" title="Ir a Índices">
                        <div style="background: white; color: #28a745; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            3
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 3:<br>Consultar</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add back button before the header container -->
<a href="./porcino_registros.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">


  <!-- New Destete Entry Modal -->
  
  <div class="modal fade" id="newDesteteModal" tabindex="-1" aria-labelledby="newDesteteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDesteteModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Destete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newDesteteForm">
                    <input type="hidden" name="id" id="new_id" value="">
                <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                                <label for="new_fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-tag"></i>
                                <label for="new_tagid" class="form-label">Tag ID</label>
                                <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                            </span>                            
                        </div>
                    </div>                    
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-weight"></i>
                                <label for="new_peso" class="form-label">Peso</label>
                                <input type="number" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>                                                              
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewDestete">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for destete records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="desteteTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Peso</th>  
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
              <?php
                  try {
                      // Query to get all animals and their LATEST destete record (if any)
                        $desteteQuery = "
                            SELECT
                                p.tagid AS porcino_tagid,
                                p.nombre AS animal_nombre,
                                p.id AS destete_id,
                                p.destete_fecha,
                                p.tagid AS destete_tagid,
                                p.destete_peso
                            FROM
                                porcino p
                            ORDER BY
                                CASE WHEN p.destete_fecha IS NOT NULL 
                                     AND p.destete_fecha != '0000-00-00' THEN 0 ELSE 1 END ASC, -- Animals with valid destete_fecha first
                                p.destete_fecha DESC, -- Then by destete date (most recent first)
                                p.tagid ASC"; // Finally by tagid

                        $stmt = $conn->prepare($desteteQuery);
                        $stmt->execute();
                        $desteteData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($desteteData)) {
                          echo "<tr><td colspan='8' class='text-center'>No hay hembras registradas</td></tr>"; // Adjusted message
                      } else {
                          // Get vigencia setting for destete records
                          $vigencia = 30; // Default value
                          
                          $currentDate = new DateTime();
                          foreach ($desteteData as $row) {
                              $hasdestete = !empty($row['destete_id']);
                              $desteteFecha = $row['destete_fecha'] ?? null;

                              echo "<tr>";

                              // Action buttons
                              echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newDesteteModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['porcino_tagid'] ?? '').'"  -- Pass tagid to modal
                                              title="Registrar Nuevo Destete">
                                          <i class="fas fa-plus"></i>
                                      </button>
                                      <button class="btn btn-warning btn-sm edit-destete" 
                                          data-id="'.htmlspecialchars($row['destete_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          data-peso="'.htmlspecialchars($row['destete_peso'] ?? '').'" 
                                          data-fecha="'.htmlspecialchars($desteteFecha ?? '').'" 
                                          title="Editar" '.(!$hasdestete ? 'disabled' : '').'>
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn btn-danger btn-sm delete-destete" 
                                          data-id="'.htmlspecialchars($row['destete_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          title="Eliminar" '.(!$hasdestete ? 'disabled' : '').'>
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>';

                              // Display data or placeholders
                              echo "<td class='text-center'>" . ($desteteFecha ? htmlspecialchars($desteteFecha) : 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['porcino_tagid'] ?? 'N/A') . "</td>"; // Now using porcino_tagid
                              echo "<td class='text-center'>" . ($hasdestete ? htmlspecialchars($row['destete_peso'] ?? '') : 'N/A') . "</td>";                              

                              // Calculate due date and determine status only if insemination exists
                              if ($hasdestete && $desteteFecha) {
                                  try {
                                      $desteteDate = new DateTime($desteteFecha);
                                      $dueDate = clone $desteteDate;
                                      $dueDate->modify("+{$vigencia} days");

                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">HISTORICO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">RECIENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $desteteFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  // Display status for animals without insemination
                                  echo '<td class="text-center"><span class="badge bg-secondary">SIN Destetes</span></td>';
                              }

                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in destete table: " . $e->getMessage());
                      echo "<tr><td colspan='8' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan from 9 to 8
                  }
                  ?>
            </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable -->
<script>
$(document).ready(function() {
    $('#desteteTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, 200, 500, -1],
            [25, 50, 100, 200, 500, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[5, 'asc']],
        
        // Spanish language
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        
        // Enable responsive features
        responsive: true,
        
        // Configure DOM layout and buttons
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12 col-md-6"l>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        
        buttons: [
            {
                extend: 'collection',
                text: 'Exportar',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        
        // Column specific settings
        columnDefs: [
            {
                targets: [1], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Parse the date parts manually to avoid timezone issues
                        if (data) {
                            // Split the date string (format: YYYY-MM-DD)
                            var parts = data.split('-');
                            // Create date string in local format (DD/MM/YYYY)
                            if (parts.length === 3) {
                                return parts[2] + '/' + parts[1] + '/' + parts[0];
                            }
                        }
                        return data; // Return original if parsing fails
                    }
                    return data;
                }
            },
            {
                targets: [5], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [1], // Actions column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    var newDesteteModalEl = document.getElementById('newDesteteModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Destete Modal opens --- 
    if (newDesteteModalEl && tagIdInput) {
        newDesteteModalEl.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget; 
            
            if (button) { // Check if modal was triggered by a button
                // Extract info from data-* attributes
                var tagid = button.getAttribute('data-tagid-prefill');
                
                // Update the modal's input field
                if (tagid) {
                    tagIdInput.value = tagid;
                } else {
                     tagIdInput.value = ''; // Clear if no tagid passed
                }
            } else {
                tagIdInput.value = ''; // Clear if opened programmatically without a relatedTarget
            }
        });

        // Optional: Clear the input when the modal is hidden to avoid stale data
        newDesteteModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newDesteteForm').removeClass('was-validated'); 
            document.getElementById('newDesteteForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---

    // Handle new entry form submission
    $('#saveNewDestete').click(function() {
        // Validate the form
        var form = document.getElementById('newDesteteForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            peso: $('#new_peso').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el destete para el animal con Tag ID ${formData.tagid}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Guardando...',
                    text: 'Por favor espere mientras se procesa la información',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send AJAX request to insert the record
                $.ajax({
                    url: 'process_destete.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        peso: formData.peso,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newDesteteModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de destete ha sido guardado correctamente',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            // Reload the page to show updated data
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMsg = response.message;
                            }
                        } catch (e) {
                            // Use default error message
                        }
                        
                        Swal.fire({
                            title: 'Error',
                            text: errorMsg,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });

    // Handle edit button click
        $('.edit-destete').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var peso = $(this).data('peso');
        var fecha = $(this).data('fecha');
        
        // Edit Destete Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editDesteteModal" tabindex="-1" aria-labelledby="editDesteteModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDesteteModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Destete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDesteteForm">
                            <input type="hidden" name="id" id="edit_id" value="${id}">
                            <div class="mb-2">                                
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                            <label for="edit_fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                        </span>
                                    </div>
                                </div>                            
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                        <label for="edit_tagid" class="form-label"> Tag ID </label>
                                        <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-weight"></i>
                                        <label for="edit_peso" class="form-label">Peso</label>                                    
                                        <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                    </span>                                    
                                </div>
                            </div>                     
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditDestete">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editDesteteModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editDesteteModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditDestete').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                peso: $('#edit_peso').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el destete para el animal con Tag ID ${formData.tagid}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Actualizando...',
                        text: 'Por favor espere mientras se procesa la información',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send AJAX request to update the record
                    $.ajax({
                        url: 'process_destete.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            peso: formData.peso,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'El destete para el animal con Tag ID ${formData.tagid} ha sido actualizada correctamente',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Reload the page to show updated data
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            // Show error message
                            let errorMsg = 'Error al procesar la solicitud';
                            
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.message) {
                                    errorMsg = response.message;
                                }
                            } catch (e) {
                                // Use default error message
                            }
                            
                            Swal.fire({
                                title: 'Error',
                                text: errorMsg,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        });
    });
    
    // Handle delete button click
    $('.delete-destete').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar destete?',
            text: `¿Está seguro de que desea eliminar el destete para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espere mientras se procesa la solicitud',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request to delete the record
                $.ajax({
                    url: 'process_destete.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El destete para el animal con Tag ID ${tagid} ha sido eliminada correctamente',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            // Reload the page to show updated data
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMsg = response.message;
                            }
                        } catch (e) {
                            // Use default error message
                        }
                        
                        Swal.fire({
                            title: 'Error',
                            text: errorMsg,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });
});
</script>


<!-- Chart Section -->
<div class="container chart-container mb-4">
    <canvas id="desteteChart"></canvas>
</div>

<!-- JavaScript for Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxDestete = document.getElementById('desteteChart').getContext('2d');
    const desteteLabels = <?php echo $chartLabelsJson; ?>;
    const desteteData = <?php echo $chartDataJson; ?>;
    const desteteAnimals = <?php echo $chartAnimalsJson; ?>;

    // Create gradient
    const gradient = ctxDestete.createLinearGradient(0, 0, 0, 400); 
    gradient.addColorStop(0, 'rgba(133, 168, 50, 0.9)'); // Brighter blue at the top
    gradient.addColorStop(1, 'rgba(219, 232, 176, 0.6)'); // Fainter blue at the bottom

    new Chart(ctxDestete, {
        type: 'bar',
        data: {
            labels: desteteLabels,
            datasets: [{
                label: 'Peso Promedio de Destete por Mes',
                data: desteteData,
                borderColor: 'rgb(133, 168, 50)', // Professional blue line
                backgroundColor: gradient, // Use gradient fill
                tension: 0.4, // Smoother curve
                fill: true,
                pointBackgroundColor: 'rgb(133, 168, 50)',
                pointBorderColor: '#000',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(133, 168, 50)',
                pointRadius: 4, // Slightly larger points
                pointHoverRadius: 6 // Larger points on hover
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                     labels: {
                        color: '#000', // Lighter gray for legend
                        font: {
                             size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Peso Promedio de Destete por Mes',
                     color: '#000', // White title
                     font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: { // Enhanced tooltips
                     enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                         size: 14,
                         weight: 'bold'
                     },
                     bodyFont: {
                         size: 12
                     },
                     padding: 10,
                     cornerRadius: 4,
                     displayColors: true, // Don't show color box in tooltip
                      callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const monthAnimals = desteteAnimals[index];
                            
                            let tooltipLines = [
                                'Mes: ' + desteteLabels[index],
                                'Peso Promedio: ' + context.parsed.y + ' kg',
                                'Animales (' + monthAnimals.length + '):',
                                '---'
                            ];
                            
                            monthAnimals.forEach(function(animal) {
                                tooltipLines.push(
                                    '• ' + (animal.nombre || 'Sin nombre') + 
                                    ' (ID: ' + animal.tagid + ') - ' + 
                                    animal.peso + ' kg'
                                );
                            });
                            
                            return tooltipLines;
                         }
                     }
                 },
                datalabels: { 
                    display: true // Keep datalabels off for a cleaner look
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Meses (YY-MM)',
                        color: '#000', 
                        font: {
                            size: 14,
                            weight: 'bold'
                         }
                    },
                     ticks: {
                        color: '#000', // Lighter gray ticks
                        font: {
                            size: 12
                        }
                    },
                     grid: {
                        color: 'rgba(0, 0, 0, 0.1)', // Very faint grid lines
                         drawBorder: false, // Hide the axis border line
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Peso Promedio de Destete (kg)',
                        color: '#000', 
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        color: '#000', // Lighter gray ticks
                        font: {
                            size: 12
                        },
                         stepSize: Math.max(1, Math.ceil(Math.max(...desteteData) / 10)), // Dynamic step size for weight
                        precision: 1 // Allow decimal places for weight
                    },
                    grid: {
                         color: 'rgba(0, 0, 0, 0.1)', // Very faint grid lines
                         drawBorder: false, // Hide the axis border line
                    }
                }
            },
             interaction: { // Improve hover interaction
                mode: 'index',
                intersect: false,
            },
        }
    });
});
</script>