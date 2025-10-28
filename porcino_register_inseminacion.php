<?php
require_once './pdo_conexion.php';  

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Fetch data for the line chart ---
$chartLabels = [];
$chartData = [];
try {
    $chartQuery = "SELECT DATE_FORMAT(ph_inseminacion_fecha, '%Y-%m') as month_year, COUNT(*) as count, GROUP_CONCAT(ph_inseminacion_tagid) as tagids, GROUP_CONCAT(ph_inseminacion_numero) as numeros FROM ph_inseminacion GROUP BY month_year ORDER BY month_year ASC";
    $chartStmt = $conn->prepare($chartQuery);
    $chartStmt->execute();
    $chartResults = $chartStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($chartResults as $row) {
        $chartLabels[] = $row['month_year'];
        $chartData[] = [
            'count' => (int)$row['count'],
            'tagids' => explode(',', $row['tagids']),
            'numeros' => explode(',', $row['numeros'])
        ];
    }
} catch (PDOException $e) {
    error_log("Error fetching chart data: " . $e->getMessage());
    // Handle error appropriately, maybe set default values or show an error message
}

// Encode data for JavaScript
$chartLabelsJson = json_encode($chartLabels);
$chartDataJson = json_encode($chartData);
// --- End chart data fetching ---

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Porcino Register Inseminacion</title>
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
                        <span class="badge-active">🎯 Registrando Inseminacion</span>
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


  <!-- New Inseminacion Entry Modal --> 
  <div class="modal fade" id="newInseminacionModal" tabindex="-1" aria-labelledby="newInseminacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newInseminacionModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Inseminacion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newInseminacionForm">
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
                                <i class="fa-solid fa-syringe"></i>
                                <label for="new_numero" class="form-label">Inse. #</label>
                                <input type="number" class="form-control" id="new_numero" name="numero" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-money-bill-1-wave"></i>
                                <label for="new_costo" class="form-label">Costo ($)</label>
                                <input type="number" step="0.01" class="form-control" id="new_costo" name="costo" required>
                            </span>                            
                        </div>
                    </div>                                          
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewInseminacion">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for inseminacion records -->  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="inseminacionTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Ins. #</th>
                      <th class="text-center">Costo ($)</th>
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get all Female animals and their LATEST insemination record (if any)
                        $inseminacionQuery = "
                            SELECT
                                p.tagid AS porcino_tagid,
                                p.nombre AS animal_nombre,
                                ins.id AS inseminacion_id,
                                ins.ph_inseminacion_fecha,
                                ins.ph_inseminacion_tagid,
                                ins.ph_inseminacion_numero,
                                ins.ph_inseminacion_costo
                            FROM
                                porcino p
                            LEFT JOIN ph_inseminacion ins
                              ON p.tagid = ins.ph_inseminacion_tagid
                            WHERE
                                p.genero = 'Hembra'
                            ORDER BY
                                p.nombre ASC,
                                ins.ph_inseminacion_fecha DESC";

                        $stmt = $conn->prepare($inseminacionQuery);
                        $stmt->execute();
                        $inseminacionData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($inseminacionData)) {
                          echo "<tr><td colspan='8' class='text-center'>No hay hembras registradas</td></tr>"; // Adjusted message
                      } else {
                          // Get vigencia setting for inseminacion records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT p_vencimiento_inseminacion FROM p_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['p_vencimiento_inseminacion'])) {
                                  $vigencia = intval($row['p_vencimiento_inseminacion']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          foreach ($inseminacionData as $row) {
                              $hasInseminacion = !empty($row['inseminacion_id']);
                              $inseminacionFecha = $row['ph_inseminacion_fecha'] ?? null;

                              echo "<tr>";

                              // Action buttons
                              echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newInseminacionModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['porcino_tagid'] ?? '').'"  -- Pass tagid to modal
                                              title="Registrar Nueva Inseminacion">
                                          <i class="fas fa-plus"></i>
                                      </button>
                                      <button class="btn btn-warning btn-sm edit-inseminacion" 
                                          data-id="'.htmlspecialchars($row['inseminacion_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          data-numero="'.htmlspecialchars($row['ph_inseminacion_numero'] ?? '').'" 
                                          data-costo="'.htmlspecialchars($row['ph_inseminacion_costo'] ?? '').'" 
                                          data-fecha="'.htmlspecialchars($inseminacionFecha ?? '').'" 
                                          title="Editar" '.(!$hasInseminacion ? 'disabled' : '').'>
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn btn-danger btn-sm delete-inseminacion" 
                                          data-id="'.htmlspecialchars($row['inseminacion_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          title="Eliminar" '.(!$hasInseminacion ? 'disabled' : '').'>
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>';

                              // Display data or placeholders
                              echo "<td class='text-center'>" . ($inseminacionFecha ? htmlspecialchars($inseminacionFecha) : 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['porcino_tagid'] ?? 'N/A') . "</td>"; // Now using porcino_tagid
                              echo "<td class='text-center'>" . ($hasInseminacion ? htmlspecialchars($row['ph_inseminacion_numero'] ?? '') : 'N/A') . "</td>";
                              echo "<td class='text-center'>" . ($hasInseminacion ? htmlspecialchars($row['ph_inseminacion_costo'] ?? '') : 'N/A') . "</td>";

                              // Calculate due date and determine status only if insemination exists
                              if ($hasInseminacion && $inseminacionFecha) {
                                  try {
                                      $inseminacionDate = new DateTime($inseminacionFecha);
                                      $dueDate = clone $inseminacionDate;
                                      $dueDate->modify("+{$vigencia} days");

                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $inseminacionFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  // Display status for animals without insemination
                                  echo '<td class="text-center"><span class="badge bg-secondary">No Inseminada</span></td>';
                              }

                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in inseminacion table: " . $e->getMessage());
                      echo "<tr><td colspan='8' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan from 9 to 8
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH inseminacion -->
<script>
$(document).ready(function() {
    $('#inseminacionTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending (now index 1)
        order: [[6, 'desc']],
        
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
                targets: [5], // Costo column - Index adjusted from 4 to 5
                render: function(data, type, row) {
                    if (type === 'display') {
                        return parseFloat(data).toLocaleString('es-ES', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    return data;
                }
            },
            {
                targets: [1], // Fecha column - Index adjusted from 0 to 1
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data && data !== 'N/A') { // Check for 'N/A'
                            // Parse the date parts manually to avoid timezone issues
                            // Split the date string (format: YYYY-MM-DD)
                            var parts = data.split('-');
                            // Create date string in local format (DD/MM/YYYY)
                            if (parts.length === 3) {
                                return parts[2] + '/' + parts[1] + '/' + parts[0];
                            }
                        }
                        return data; // Return 'N/A' or original if parsing fails
                    }
                    return data;
                }
            },
            {
                targets: [6], // Status column - Index adjusted from 5 to 6
                orderable: true,
                searchable: true
            },
            {
                targets: [0], // Actions column - Index adjusted from 6 to 0
                orderable: false,
                searchable: false
            }
        ]
    });

    // --- New code to handle pre-filling Tag ID --- 
    var newInseminacionModal = document.getElementById('newInseminacionModal');
    var tagIdInput = document.getElementById('new_tagid');

    newInseminacionModal.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget;
      // Extract info from data-tagid-prefill attribute
      var tagIdToPrefill = button.getAttribute('data-tagid-prefill');
      
      // Update the modal's input field
      if (tagIdInput && tagIdToPrefill) {
        tagIdInput.value = tagIdToPrefill;
      } else if (tagIdInput) {
        // Clear the input if no prefill info (e.g., modal opened via a different button)
        tagIdInput.value = ''; 
      }
      
      // Reset other fields potentially?
      // document.getElementById('new_numero').value = '';
      // document.getElementById('new_costo').value = '';
      // document.getElementById('new_fecha').value = '<?php echo date('Y-m-d'); ?>'; // Reset date
    });
    // --- End of new code --- 

});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // Handle new entry form submission
    $('#saveNewInseminacion').click(function() {
        // Validate the form
        var form = document.getElementById('newInseminacionForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            numero: $('#new_numero').val(),
            costo: $('#new_costo').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar la inseminacion ${formData.numero} para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_inseminacion.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        numero: formData.numero,
                        costo: formData.costo,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newInseminacionModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de inseminacion ha sido guardado correctamente',
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
    $('.edit-inseminacion').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var numero = $(this).data('numero');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        
        // Edit Inseminacion Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editInseminacionModal" tabindex="-1" aria-labelledby="editInseminacionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editInseminacionModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Dosis de Inseminacion
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editInseminacionForm">
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
                                        <i class="fas fa-syringe"></i>
                                        <label for="edit_numero" class="form-label">Numero</label>                                    
                                        <input type="text" class="form-control" id="edit_numero" value="${numero}" required>
                                    </span>                                    
                                </div>
                            </div>                            
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_costo" class="form-label">Costo ($)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_costo" value="${costo}" required>
                                    </span>
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditInseminacion">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editInseminacionModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editInseminacionModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditInseminacion').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                numero: $('#edit_numero').val(),
                costo: $('#edit_costo').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el registro de inseminacion para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_inseminacion.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            numero: formData.numero,
                            costo: formData.costo,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'El registro ha sido actualizado correctamente',
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
    $('.delete-inseminacion').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `¿Está seguro de que desea eliminar el registro para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                    url: 'process_inseminacion.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El registro ha sido eliminado correctamente',
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
    <canvas id="inseminacionChart"></canvas>
</div>

<!-- JavaScript for Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxInseminacion = document.getElementById('inseminacionChart').getContext('2d');
    const inseminacionLabels = <?php echo $chartLabelsJson; ?>;
    const inseminacionData = <?php echo $chartDataJson; ?>;

    // Create gradient
    const gradient = ctxInseminacion.createLinearGradient(0, 0, 0, 400); 
    gradient.addColorStop(0, 'rgba(133, 168, 50, 0.6)'); // Brighter blue at the top
    gradient.addColorStop(1, 'rgba(219, 232, 176, 0.1)'); // Fainter blue at the bottom

    const chart = new Chart(ctxInseminacion, {
        type: 'bar',
        data: {
            labels: inseminacionLabels,
            datasets: [{
                label: 'Número de Inseminaciones',
                data: inseminacionData.map(item => item.count),
                backgroundColor: gradient,
                borderColor: 'rgb(133, 168, 50)',
                borderWidth: 1
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
                        color: '#000',
                        font: {
                            size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Historial Mensual de Registros de Inseminación',
                    color: '#000',
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const dataIndex = context.dataIndex;
                            const item = inseminacionData[dataIndex];
                            const tooltipLines = [
                                `Cantidad: ${item.count}`,
                                'Animales:'
                            ];
                            
                            // Add each animal's info
                            for (let i = 0; i < item.tagids.length; i++) {
                                tooltipLines.push(`TagID: ${item.tagids[i]} - Inseminación #${item.numeros[i]}`);
                            }
                            
                            return tooltipLines;
                        }
                    }
                }
            }
        }
    });
});
</script>

