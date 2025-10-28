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
    $chartQuery = "SELECT 
                    DATE_FORMAT(ph_gestacion_fecha, '%Y-%m') as month_year,
                    COUNT(*) as count,
                    GROUP_CONCAT(DISTINCT CONCAT(ph_gestacion_tagid, ':', ph_gestacion_numero)) as tagid_numeros
                  FROM ph_gestacion 
                  GROUP BY month_year 
                  ORDER BY month_year ASC";
    $chartStmt = $conn->prepare($chartQuery);
    $chartStmt->execute();
    $chartResults = $chartStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($chartResults as $row) {
        $chartLabels[] = $row['month_year'];
        
        // Parse the concatenated tagid:numero pairs
        $tagidNumeros = explode(',', $row['tagid_numeros']);
        $tagids = [];
        $numeros = [];
        foreach ($tagidNumeros as $pair) {
            list($tagid, $numero) = explode(':', $pair);
            $tagids[] = $tagid;
            $numeros[] = $numero;
        }
        
        $chartData[] = [
            'count' => (int)$row['count'],
            'tagids' => $tagids,
            'numeros' => $numeros
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
<title>Porcino Register Gestacion</title>
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
                        <span class="badge-active">🎯 Registrando Gestaciones</span>
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

  
  <!-- New Gestacion Entry Modal -->
  
  <div class="modal fade" id="newGestacionModal" tabindex="-1" aria-labelledby="newGestacionModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newGestacionModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Gestacion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newGestacionForm">
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
                                <i class="fa-solid fa-syringe"></i>
                                <label for="new_numero" class="form-label">Gest. #</label>
                                <input type="number" class="form-control" id="new_numero" name="numero" required>
                            </span>                            
                        </div>
                    </div>                                                              
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewGestacion">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for ph_gestacion records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="gestacionTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Gest. #</th>  
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
              <?php
                  try {
                      // Query to get all Female animals and their LATEST gestacion record (if any)
                        $gestacionQuery = "
                            SELECT
                                p.tagid AS porcino_tagid,
                                p.nombre AS animal_nombre,
                                ins.id AS gestacion_id,
                                ins.ph_gestacion_fecha,
                                ins.ph_gestacion_tagid,
                                ins.ph_gestacion_numero
                            FROM
                                porcino p
                            LEFT JOIN ph_gestacion ins
                              ON p.tagid = ins.ph_gestacion_tagid
                            WHERE
                                p.genero = 'Hembra'
                            ORDER BY
                                p.nombre ASC,
                                ins.ph_gestacion_fecha DESC";

                        $stmt = $conn->prepare($gestacionQuery);
                        $stmt->execute();
                        $gestacionData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($gestacionData)) {
                          echo "<tr><td colspan='8' class='text-center'>No hay hembras registradas</td></tr>"; // Adjusted message
                      } else {
                          // Get vigencia setting for gestacion records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT p_vencimiento_gestacion FROM p_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['p_vencimiento_gestacion'])) {
                                  $vigencia = intval($row['p_vencimiento_gestacion']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          foreach ($gestacionData as $row) {
                              $hasgestacion = !empty($row['gestacion_id']);
                              $gestacionFecha = $row['ph_gestacion_fecha'] ?? null;

                              echo "<tr>";

                              // Action buttons
                              echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newGestacionModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['porcino_tagid'] ?? '').'"  -- Pass tagid to modal
                                              title="Registrar Nueva gestacion">
                                          <i class="fas fa-plus"></i>
                                      </button>
                                      <button class="btn btn-warning btn-sm edit-gestacion" 
                                          data-id="'.htmlspecialchars($row['gestacion_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          data-numero="'.htmlspecialchars($row['ph_gestacion_numero'] ?? '').'" 
                                          data-fecha="'.htmlspecialchars($gestacionFecha ?? '').'" 
                                          title="Editar" '.(!$hasgestacion ? 'disabled' : '').'>
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn btn-danger btn-sm delete-gestacion" 
                                          data-id="'.htmlspecialchars($row['gestacion_id'] ?? '').'" 
                                          data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                          title="Eliminar" '.(!$hasgestacion ? 'disabled' : '').'>
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>';

                              // Display data or placeholders
                              echo "<td class='text-center'>" . ($gestacionFecha ? htmlspecialchars($gestacionFecha) : 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['porcino_tagid'] ?? 'N/A') . "</td>"; // Now using porcino_tagid
                              echo "<td class='text-center'>" . ($hasgestacion ? htmlspecialchars($row['ph_gestacion_numero'] ?? '') : 'N/A') . "</td>";                              

                              // Calculate due date and determine status only if insemination exists
                              if ($hasgestacion && $gestacionFecha) {
                                  try {
                                      $gestacionDate = new DateTime($gestacionFecha);
                                      $dueDate = clone $gestacionDate;
                                      $dueDate->modify("+{$vigencia} days");

                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $gestacionFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  // Display status for animals without insemination
                                  echo '<td class="text-center"><span class="badge bg-secondary">No Preñada</span></td>';
                              }

                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in gestacion table: " . $e->getMessage());
                      echo "<tr><td colspan='8' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan from 9 to 8
                  }
                  ?>
            </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH gestacion -->
<script>
$(document).ready(function() {
    $('#gestacionTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[5, 'desc']],
        
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
                targets: [4], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [5], // Actions column
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
    var newGestacionModalEl = document.getElementById('newGestacionModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Gestacion Modal opens --- 
    if (newGestacionModalEl && tagIdInput) {
        newGestacionModalEl.addEventListener('show.bs.modal', function (event) {
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
        newGestacionModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newGestacionForm').removeClass('was-validated'); 
            document.getElementById('newGestacionForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---

    // Handle new entry form submission
    $('#saveNewGestacion').click(function() {
        // Validate the form
        var form = document.getElementById('newGestacionForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            numero: $('#new_numero').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar la gestacion numero ${formData.numero} para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_gestacion.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        numero: formData.numero,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newGestacionModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de gestacion ha sido guardado correctamente',
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
    $('.edit-gestacion').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var numero = $(this).data('numero');
        var fecha = $(this).data('fecha');
        
        // Edit Gestacion Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editGestacionModal" tabindex="-1" aria-labelledby="editGestacionModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGestacionModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Gestacion
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editGestacionForm">
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
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditGestacion">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editGestacionModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editGestacionModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditGestacion').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                numero: $('#edit_numero').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la gestacion numero ${formData.numero} para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_gestacion.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            numero: formData.numero,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'La gestacion numero ${formData.numero} ha sido actualizada correctamente',
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
});
</script>



<!-- Chart Section -->
<div class="container chart-container mb-4">
    <canvas id="gestacionChart"></canvas>
</div>

<!-- JavaScript for Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxGestacion = document.getElementById('gestacionChart').getContext('2d');
    const gestacionLabels = <?php echo $chartLabelsJson; ?>;
    const gestacionData = <?php echo $chartDataJson; ?>;

    // Create gradient
    const gradient = ctxGestacion.createLinearGradient(0, 0, 0, 400); 
    gradient.addColorStop(0, 'rgba(133, 168, 50, 0.6)'); // Brighter blue at the top
    gradient.addColorStop(1, 'rgba(219, 232, 176, 0.1)'); // Fainter blue at the bottom

    new Chart(ctxGestacion, {
        type: 'bar',
        data: {
            labels: gestacionLabels,
            datasets: [{
                label: 'Número de Gestaciones por Mes',
                data: gestacionData.map(item => item.count),
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
                    text: 'Historial Mensual de Gestaciones',
                     color: '#000', // White title
                     font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const dataIndex = context.dataIndex;
                            const item = gestacionData[dataIndex];
                            const tooltipLines = [
                                `Cantidad: ${item.count}`,
                                'Animales:'
                            ];
                            
                            // Add each animal's info
                            for (let i = 0; i < item.tagids.length; i++) {
                                tooltipLines.push(`TagID: ${item.tagids[i]} - Gestación #${item.numeros[i]}`);
                            }
                            
                            return tooltipLines;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Meses (Año-Mes)',
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
                        text: 'Cantidad de Gestaciones',
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
                         stepSize: Math.max(1, Math.ceil(Math.max(...gestacionData.map(item => item.count)) / 5)), // Dynamic step size (aim for ~5 steps)
                        precision: 0 // Ensure whole numbers for counts
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
<script>
// Wait for the document to be fully loaded
$(document).ready(function() {
    // Add click event listener to all delete-gestacion buttons
    $(document).on('click', '.delete-gestacion', function(e) {
        e.preventDefault();
        
        // Get the ID from the data-id attribute
        const gestacionId = $(this).data('id');
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // If user confirms the deletion
            if (result.isConfirmed) {
                // Send AJAX request to delete the record
                $.ajax({
                    url: 'process_gestacion.php',
                    type: 'POST',
                    dataType: 'json', // Explicitly tell jQuery to expect JSON
                    data: {
                        id: gestacionId,
                        action: 'delete'
                    },
                    success: function(data) {
                        // No need to parse again, jQuery does it automatically
                        if (data.success) {
                            // Show success message
                            Swal.fire(
                                'Eliminado!',
                                'El registro ha sido eliminado.',
                                'success'
                            ).then(() => {
                                // Reload the page
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire(
                                'Error!',
                                data.message || 'No se pudo eliminar el registro.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message for AJAX error
                        let errorMessage = 'Error de conexión';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            errorMessage += ': ' + error;
                        }
                        
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                        console.error('AJAX error:', xhr.responseText);
                    }
                });
            }
        });
    });
});
</script>
