<?php
require_once './pdo_conexion.php';  

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Porcino - Registro de Alimento Concentrado</title>
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
<body>
<!-- Icon Navigation Buttons -->

<div class="container nav-icons-container">
    <div class="icon-button-container">
        <button onclick="window.location.href='../inicio.php'" class="icon-button">
            <img src="./images/default_image.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">INICIO</span>
    </div>
    
    <div class="icon-button-container">
        <button onclick="window.location.href='./inventario_porcino.php'" class="icon-button">
            <img src="./images/veterinario-ia.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">VETERINARIO</span>
    </div>
    
    <div class="icon-button-container">
        <button onclick="window.location.href='./porcino_indices.php'" class="icon-button">
            <img src="./images/indices.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">INDICES</span>
    </div>

    <div class="icon-button-container">
            <button onclick="window.location.href='./porcino_configuracion.php'" class="icon-button">
                <img src="./images/configuracion.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">CONFIG</span>
        </div>

</div>


<!-- Add back button before the header container -->
<a href="./porcino_registros.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="concentrado">
  REGISTROS DE ALIMENTO CONCENTRADO
  </h3>
    
  <!-- New Concentrado Entry Modal -->
  
  <div class="modal fade" id="newConcentradoModal" tabindex="-1" aria-labelledby="newConcentradoModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newConcentradoModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Concentrado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newConcentradoForm">
                    <input type="hidden" name="id" id="new_id" value="">
                    
                    <div class="mb-3">
                        <label for="new_fecha" class="form-label">
                            <i class="fas fa-calendar me-2"></i>Fecha Inicio
                        </label>
                        <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_fecha_final" class="form-label">
                            <i class="fas fa-calendar me-2"></i>Fecha Final
                        </label>
                        <input type="date" class="form-control" id="new_fecha_final" name="fecha_final" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_tagid" class="form-label">
                            <i class="fas fa-tag me-2"></i>Tag ID
                        </label>
                        <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_etapa" class="form-label">
                            <i class="fa-solid fa-syringe me-2"></i>Etapa
                        </label>
                        <select class="form-select" id="new_etapa" name="etapa" required>
                            <option value="">Seleccionar</option>
                            <?php
                            try {
                                $sql_etapas = "SELECT DISTINCT pc_etapas_nombre FROM pc_etapas ORDER BY pc_etapas_nombre ASC";
                                $stmt_etapas = $conn->prepare($sql_etapas);
                                $stmt_etapas->execute();
                                $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($etapas as $etapa_row) {
                                    echo '<option value="' . htmlspecialchars($etapa_row['pc_etapas_nombre']) . '">' . htmlspecialchars($etapa_row['pc_etapas_nombre']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                error_log("Error fetching etapas: " . $e->getMessage());
                                echo '<option value="">Error al cargar etapas</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_alimento" class="form-label">
                            <i class="fa-solid fa-syringe me-2"></i>Concentrado
                        </label>
                        <select class="form-select" id="new_alimento" name="alimento" required>
                            <option value="">Productos</option>
                            <?php
                            try {
                                $sql_alimentos = "SELECT DISTINCT pc_concentrado_nombre FROM pc_concentrado ORDER BY pc_concentrado_nombre ASC";
                                $stmt_alimentos = $conn->prepare($sql_alimentos);
                                $stmt_alimentos->execute();
                                $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($alimentos as $alimento_row) {
                                    echo '<option value="' . htmlspecialchars($alimento_row['pc_concentrado_nombre']) . '">' . htmlspecialchars($alimento_row['pc_concentrado_nombre']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                error_log("Error fetching alimentos: " . $e->getMessage());
                                echo '<option value="">Error al cargar alimentos</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_racion" class="form-label">
                            <i class="fa-solid fa-weight me-2"></i>Racion
                        </label>
                        <input type="text" class="form-control" id="new_racion" name="racion" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_costo" class="form-label">
                            <i class="fa-solid fa-dollar-sign me-2"></i>Costo
                        </label>
                        <input type="text" class="form-control" id="new_costo" name="costo" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewConcentrado">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for ph_concentrado records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="concentradoTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Etapa</th>
                      <th class="text-center">Producto</th>
                      <th class="text-center">Racion (kg)</th>
                      <th class="text-center">Costo ($/kg)</th>
                      <th class="text-center">Valor Total ($)</th>
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get all Animals and ALL their concentrado records (if any)
                        $concentradoQuery = "
                            SELECT
                                p.tagid AS porcino_tagid,
                                p.nombre AS animal_nombre,
                                c.id AS concentrado_id,         -- Will be NULL for animals with no concentrado records
                                c.ph_concentrado_fecha_inicio,
                                c.ph_concentrado_fecha_fin,
                                c.ph_concentrado_tagid,         -- Matches porcino_tagid if concentrado exists
                                c.ph_concentrado_etapa,
                                c.ph_concentrado_producto,
                                c.ph_concentrado_racion,
                                c.ph_concentrado_costo,
                                -- Calculate total_value only if c.id is not null
                                CASE WHEN c.id IS NOT NULL THEN CAST((c.ph_concentrado_racion * c.ph_concentrado_costo) AS DECIMAL(10,2)) ELSE NULL END as total_value
                            FROM
                                porcino p
                            LEFT JOIN
                                ph_concentrado c ON p.tagid = c.ph_concentrado_tagid -- Join ALL matching concentrado records
                            ORDER BY
                                -- Prioritize animals with records (IS NOT NULL -> 0, IS NULL -> 1)
                                CASE WHEN c.id IS NOT NULL THEN 0 ELSE 1 END ASC,
                                -- Then order by animal tag ID to group them
                                p.tagid ASC,
                                -- Within each animal, order their concentrado records by date descending
                                c.ph_concentrado_fecha_inicio DESC";

                        $stmt = $conn->prepare($concentradoQuery);
                        $stmt->execute();
                        $concentradoData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($concentradoData)) {
                          echo "<tr><td colspan='10' class='text-center'>No hay animales registrados</td></tr>"; // Message adjusted
                      } else {
                          // Get vigencia setting for concentrado records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT p_vencimiento_concentrado FROM p_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['p_vencimiento_concentrado'])) {
                                  $vigencia = intval($row['p_vencimiento_concentrado']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          
                          foreach ($concentradoData as $row) {
                              $hasConcentrado = !empty($row['concentrado_id']);
                              $concentradoFecha = $row['ph_concentrado_fecha_inicio'] ?? null;

                              echo "<tr>";

                              // Column 1: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              // Always show Add Button
                              echo '        <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newConcentradoModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                              title="Registrar Nuevo Concentrado">
                                              <i class="fas fa-plus"></i>
                                          </button>';
                              
                              if ($hasConcentrado) {
                                  // Edit Button (only if concentrado exists)
                                  echo '        <button class="btn btn-warning btn-sm edit-concentrado" 
                                                  data-id="'.htmlspecialchars($row['concentrado_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                                  data-etapa="'.htmlspecialchars($row['ph_concentrado_etapa'] ?? '').'" 
                                                  data-producto="'.htmlspecialchars($row['ph_concentrado_producto'] ?? '').'" 
                                                  data-racion="'.htmlspecialchars($row['ph_concentrado_racion'] ?? '').'" 
                                                  data-costo="'.htmlspecialchars($row['ph_concentrado_costo'] ?? '').'" 
                                                  data-fecha="'.htmlspecialchars($concentradoFecha ?? '').'" 
                                                  data-fecha-final="'.htmlspecialchars($row['ph_concentrado_fecha_fin'] ?? '').'" 
                                                  title="Editar Registro">
                                                  <i class="fas fa-edit"></i>
                                              </button>';
                                  // Delete Button (only if concentrado exists)
                                  echo '        <button class="btn btn-danger btn-sm delete-concentrado" 
                                                  data-id="'.htmlspecialchars($row['concentrado_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                                  title="Eliminar Registro">
                                                  <i class="fas fa-trash"></i>
                                              </button>';
                              }
                              echo '    </div>';
                              echo '</td>';

                              // Column 2: Fecha Concentrado (or N/A)
                              echo "<td>" . ($concentradoFecha ? htmlspecialchars(date('d/m/Y', strtotime($concentradoFecha))) : 'N/A') . "</td>";
                              // Column 3: Nombre Animal
                              echo "<td>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              // Column 4: Tag ID Animal
                              echo "<td>" . htmlspecialchars($row['porcino_tagid'] ?? 'N/A') . "</td>";
                              // Column 5: Etapa (or N/A)
                              echo "<td>" . ($hasConcentrado ? htmlspecialchars($row['ph_concentrado_etapa'] ?? '') : 'N/A') . "</td>";
                              // Column 6: Producto (or N/A)
                              echo "<td>" . ($hasConcentrado ? htmlspecialchars($row['ph_concentrado_producto'] ?? '') : 'N/A') . "</td>";
                              // Column 7: Racion (or N/A)
                              echo "<td>" . ($hasConcentrado ? htmlspecialchars($row['ph_concentrado_racion'] ?? '') : 'N/A') . "</td>";
                              // Column 8: Costo (or N/A)
                              echo "<td>" . ($hasConcentrado ? htmlspecialchars($row['ph_concentrado_costo'] ?? '') : 'N/A') . "</td>";
                              // Column 9: Valor Total (or N/A)
                              echo "<td>" . ($hasConcentrado && isset($row['total_value']) ? htmlspecialchars($row['total_value']) : 'N/A') . "</td>";
                              
                              // Column 10: Estatus (or N/A)
                              if ($hasConcentrado && $concentradoFecha) {
                                  try {
                                      $concentradoDate = new DateTime($concentradoFecha);
                                      $dueDate = clone $concentradoDate;
                                      $dueDate->modify("+{$vigencia} days");
                                      
                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $concentradoFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  echo '<td class="text-center"><span class="badge bg-secondary">Sin Registro</span></td>'; // Status if no concentrado
                              }
                              
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in concentrado table: " . $e->getMessage());
                      echo "<tr><td colspan='10' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan to 10
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH Concentrado -->
<script>
$(document).ready(function() {
    $('#concentradoTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[1, 'desc']],
        
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
                targets: [0], // Actions column
                orderable: false,
                searchable: false
            },
            {
                targets: [6, 7, 8], // Racion, Costo, Valor Total columns
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'N/A') return data; // Pass through 'N/A'
                        const number = parseFloat(data);
                        if (!isNaN(number)) {
                            return number.toLocaleString('es-ES', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        } else {
                            return data; // Return original if parsing failed but wasn't N/A
                        }
                    }
                    return data;
                }
            },
            {
                targets: [1], // Fecha column
                type: 'date-eu', // Help DataTables sort European date format
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'N/A') return data; // Pass through 'N/A'
                        // Date is already formatted DD/MM/YYYY in PHP
                        return data; 
                    }
                    // For sorting/filtering, return the original YYYY-MM-DD if possible, or null
                    if (type === 'sort' || type === 'filter') {
                         // We need the original YYYY-MM-DD date here for correct sorting.
                         // Let's assume the raw data is the 2nd element in the row array `row[1]`
                         // Note: This depends on DataTables internal structure and might need adjustment
                         // A better approach is to fetch YYYY-MM-DD in PHP and pass it via a hidden column or data attribute
                         // For now, let's try getting it from the raw row data for the corresponding display column
                         // If the display data `data` is 'N/A', sorting value should be null or minimal
                         if (data === 'N/A') return null; 
                         // Attempt to convert DD/MM/YYYY back to YYYY-MM-DD for sorting
                         const parts = data.split('/');
                         if (parts.length === 3) {
                            return parts[2] + '-' + parts[1] + '-' + parts[0];
                         }
                         return null; // Fallback if conversion fails
                    }
                    return data;
                }
            },
            {
                targets: [9], // Status column
                orderable: true,
                searchable: true
            }
        ]
    });
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    var newConcentradoModalEl = document.getElementById('newConcentradoModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Concentrado Modal opens --- 
    if (newConcentradoModalEl && tagIdInput) {
        newConcentradoModalEl.addEventListener('show.bs.modal', function (event) {
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
        newConcentradoModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newConcentradoForm').removeClass('was-validated'); 
            document.getElementById('newConcentradoForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---
    
    // Handle new entry form submission
    $('#saveNewConcentrado').click(function() {
        // Validate the form
        var form = document.getElementById('newConcentradoForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            racion: $('#new_racion').val(),
            etapa: $('#new_etapa').val(),
            producto: $('#new_alimento').val(),
            costo: $('#new_costo').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el registro de alimento concentrado ${formData.racion} kg para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_concentrado.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        racion: formData.racion,
                        etapa: formData.etapa,
                        producto: formData.producto,
                        costo: formData.costo,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newConcentradoModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de alimento concentrado ha sido guardado correctamente',
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
    $('.edit-concentrado').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var etapa = $(this).data('etapa');
        var producto = $(this).data('producto');
        var racion = $(this).data('racion');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        var fechaFinal = $(this).data('fecha-final');
        
        // Edit Concentrado Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editConcentradoModal" tabindex="-1" aria-labelledby="editConcentradoModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editConcentradoModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Alimento Concentrado
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editConcentradoForm">
                            <input type="hidden" id="edit_id" value="${id}">
                            
                            <div class="mb-3">
                                <label for="edit_fecha" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha Inicio
                                </label>
                                <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_fecha_final" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha Final
                                </label>
                                <input type="date" class="form-control" id="edit_fecha_final" value="${fechaFinal}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_tagid" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Tag ID
                                </label>
                                <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_producto" class="form-label">
                                    <i class="fa-solid fa-syringe me-2"></i>Concentrado
                                </label>
                                <select class="form-select" id="edit_producto" name="producto" required>
                                    <option value="">Productos</option>
                                    <?php
                                    try {
                                        $sql_alimentos = "SELECT DISTINCT pc_concentrado_nombre FROM pc_concentrado ORDER BY pc_concentrado_nombre ASC";
                                        $stmt_alimentos = $conn->prepare($sql_alimentos);
                                        $stmt_alimentos->execute();
                                        $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alimentos as $alimento_row) {
                                            echo '<option value="' . htmlspecialchars($alimento_row['pc_concentrado_nombre']) . '">' . htmlspecialchars($alimento_row['pc_concentrado_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching alimentos: " . $e->getMessage());
                                        echo '<option value="">Error al cargar alimentos</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_etapa" class="form-label">
                                    <i class="fa-solid fa-syringe me-2"></i>Etapa
                                </label>
                                <select class="form-select" id="edit_etapa" name="etapa" required>
                                    <option value="">Etapas</option>
                                    <?php
                                    try {
                                        $sql_alimentos = "SELECT DISTINCT pc_etapas_nombre FROM pc_etapas ORDER BY pc_etapas_nombre ASC";
                                        $stmt_alimentos = $conn->prepare($sql_alimentos);
                                        $stmt_alimentos->execute();
                                        $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alimentos as $alimento_row) {
                                            echo '<option value="' . htmlspecialchars($alimento_row['pc_etapas_nombre']) . '">' . htmlspecialchars($alimento_row['pc_etapas_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching etapas: " . $e->getMessage());
                                        echo '<option value="">Error al cargar etapas</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_racion" class="form-label">
                                    <i class="fas fa-weight me-2"></i>Racion (kg)
                                </label>
                                <input type="number" step="0.01" class="form-control" id="edit_racion" value="${racion}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_costo" class="form-label">
                                    <i class="fas fa-dollar-sign me-2"></i>Costo ($/kg)
                                </label>
                                <input type="number" step="0.01" class="form-control" id="edit_costo" value="${costo}" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditConcentrado">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editConcentradoModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editConcentradoModal'));
        editModal.show();
        
        // Set the selected values for dropdowns after modal is shown
        setTimeout(function() {
            $('#edit_producto').val(producto);
            $('#edit_etapa').val(etapa);
        }, 100);
        
        // Handle save button click
        $('#saveEditConcentrado').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                racion: $('#edit_racion').val(),
                etapa: $('#edit_etapa').val(),
                producto: $('#edit_producto').val(),
                costo: $('#edit_costo').val(),
                fecha: $('#edit_fecha').val(),
                fecha_final: $('#edit_fecha_final').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el registro de alimento concentrado para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_concentrado.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            racion: formData.racion,
                            etapa: formData.etapa,
                            producto: formData.producto,
                            costo: formData.costo,
                            fecha: formData.fecha,
                            fecha_final: formData.fecha_final
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
    $('.delete-concentrado').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).closest('tr').find('td:eq(3)').text().trim(); // Get Tag ID from the 4th column
        
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
                    url: 'process_concentrado.php',
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

<!-- Concentrado Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución Costo por Ración de Alimento Concentrado</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Últimos 20 alimentos</option>
                        <option value="50">Últimos 50 alimentos</option>
                        <option value="100">Últimos 100 alimentos</option>
                        <option value="all">Todos los alimentos</option>
                    </select>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="concentradoChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Concentrado Line Chart -->
<script>
$(document).ready(function() {
    let allConcentradoData = [];
    let concentradoChart = null;
    
    // Fetch concentrado data and create the chart
    $.ajax({
        url: 'get_concentrado_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allConcentradoData = data;
            populateAnimalFilter(data);
            createConcentradoChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching concentrado data:', error);
        }
    });
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.tagid && !uniqueTagIds.has(item.tagid)) {
                uniqueTagIds.add(item.tagid);
                animals.push({
                    tagid: item.tagid,
                    nombre: item.animal_nombre || 'Sin nombre'
                });
            }
        });
        
        // Sort animals by name
        animals.sort((a, b) => a.nombre.localeCompare(b.nombre));
        
        // Add options to the dropdown
        const animalFilter = $('#animalFilter');
        animals.forEach(animal => {
            animalFilter.append(`<option value="${animal.tagid}">${animal.nombre} (${animal.tagid})</option>`);
        });
    }
    
    function updateChart() {
        const selectedAnimal = $('#animalFilter').val();
        const selectedRange = $('#dataRangeFilter').val();
        
        let filteredData = [...allConcentradoData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.tagid === selectedAnimal);
        }
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (concentradoChart) {
            concentradoChart.destroy();
        }
        createConcentradoChart(data);
    }
    
    function createConcentradoChart(data) {
        var ctx = document.getElementById('concentradoChart').getContext('2d');
        
        // Group data by month and calculate average cost per month
        const monthlyData = {};
        
        data.forEach(function(item) {
            const date = new Date(item.fecha);
            const monthKey = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
            
            if (!monthlyData[monthKey]) {
                monthlyData[monthKey] = {
                    costs: [],
                    animalName: item.animal_nombre,
                    tagid: item.tagid
                };
            }
            
            const cost = parseFloat(item.ph_concentrado_cantidad) || 0;
            if (cost > 0) {
                monthlyData[monthKey].costs.push(cost);
            }
        });
        
        // Convert to arrays and calculate averages
        const monthlyEntries = Object.entries(monthlyData)
            .map(([monthKey, data]) => ({
                month: monthKey,
                averageCost: data.costs.length > 0 
                    ? data.costs.reduce((sum, cost) => sum + cost, 0) / data.costs.length 
                    : 0,
                animalName: data.animalName,
                tagid: data.tagid,
                recordCount: data.costs.length
            }))
            .sort((a, b) => a.month.localeCompare(b.month));
        
        // Format the data for the main chart labels and values
        var labels = monthlyEntries.map(function(item) {
            // Format month as "yy-mm" (e.g., "24-01")
            const [year, month] = item.month.split('-');
            const shortYear = year.slice(-2); // Get last 2 digits of year
            return shortYear + '-' + month;
        });
        
        var concentradoCosts = monthlyEntries.map(function(item) {
            return item.averageCost;
        });
        
        concentradoChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Costo Promedio Ración Mensual ($/Kg)',
                    data: concentradoCosts,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Ración Mensual ($/Kg)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes (YY-MM)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var index = context.dataIndex;
                                var value = context.parsed.y;
                                let tooltipText = [];
                                
                                tooltipText.push('Costo Promedio: $ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + '/Kg');
                                
                                // Add monthly data info
                                var monthlyPoint = monthlyEntries[index];
                                if (monthlyPoint) {
                                    tooltipText.push('Registros: ' + monthlyPoint.recordCount);
                                    if (monthlyPoint.animalName && $('#animalFilter').val() !== 'all') {
                                        tooltipText.unshift('Animal: ' + monthlyPoint.animalName);
                                    }
                                }
                                
                                return tooltipText;
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            let baseTitle = 'Evolución Costo Ración Alimento Concentrado Mensual (Promedio)';
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                baseTitle = 'Costo Ración Alimento Concentrado Mensual - ' + animalName;
                            }
                            return baseTitle;
                        },
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Gasto Total Mensual en Concentrado</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyExpenseChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let monthlyExpenseChart = null;

    // Fetch monthly expense data and create the chart
    $.ajax({
        url: 'get_monthly_expense_data.php', // New endpoint
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error fetching monthly expense:', data.error);
                return;
            }
            createMonthlyExpenseChart(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense data:', error);
        }
    });

    function createMonthlyExpenseChart(data) {
        var ctx = document.getElementById('monthlyExpenseChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            // Display month and year (YYYY-MM)
            return item.month;
        });

        var expenses = data.map(function(item) {
            return parseFloat(item.total_expense) || 0;
        });

        monthlyExpenseChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Total Mensual ($)',
                    data: expenses,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', // Primary blue
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Gasto Total ($)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Gasto Total: $ ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Gasto Total Mensual en Alimento Concentrado',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Gasto Acumulado Mensual en Concentrado</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="cumulativeExpenseChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Cumulative Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let cumulativeExpenseChart = null;

    // Fetch the SAME monthly expense data used for the total monthly chart
    $.ajax({
        url: 'get_monthly_expense_data.php', // Using the same endpoint
        type: 'GET',
        dataType: 'json',
        success: function(monthlyData) {
            if (monthlyData.error) {
                console.error('Server error fetching monthly expense for cumulative chart:', monthlyData.error);
                return;
            }
            if (!Array.isArray(monthlyData) || monthlyData.length === 0) {
                 console.warn('No monthly data received for cumulative chart.');
                 // Optionally display a message in the chart area
                 $('#cumulativeExpenseChart').parent().html('<p class="text-center">No hay datos disponibles para mostrar el gasto acumulado.</p>');
                 return;
            }

            // Calculate cumulative data
            let cumulativeTotal = 0;
            const cumulativeData = monthlyData.map(item => {
                cumulativeTotal += parseFloat(item.total_expense) || 0;
                return {
                    month: item.month,
                    cumulative_expense: cumulativeTotal
                };
            });

            createCumulativeExpenseChart(cumulativeData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense data for cumulative chart:', error);
             $('#cumulativeExpenseChart').parent().html('<p class="text-center text-danger">Error al cargar datos para el gráfico acumulado.</p>');
        }
    });

    function createCumulativeExpenseChart(data) {
        var ctx = document.getElementById('cumulativeExpenseChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var cumulativeExpenses = data.map(function(item) {
            return parseFloat(item.cumulative_expense) || 0;
        });

        cumulativeExpenseChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Acumulado Mensual ($)',
                    data: cumulativeExpenses,
                    backgroundColor: 'rgba(23, 162, 184, 0.2)', // Info blue color
                    borderColor: 'rgba(23, 162, 184, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(23, 162, 184, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.1, // Slightly less tension for cumulative might look better
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Gasto Acumulado ($)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Acumulado hasta ' + context.label + ': $ ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            },
                            title: function(tooltipItems) {
                                // Display just the month in the title
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Gasto Acumulado Mensual en Alimento Concentrado',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark"> <!-- Changed color for variety -->
            <h5 class="mb-0"><i class="fas fa-weight-hanging me-2"></i>Peso Total Mensual Registrado</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyWeightChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Total Weight Line Chart -->
<script>
$(document).ready(function() {
    let monthlyWeightChart = null;

    // Fetch monthly weight data
    $.ajax({
        url: 'get_monthly_weight_data.php', // New endpoint for weight data
        type: 'GET',
        dataType: 'json',
        success: function(weightData) {
            if (weightData.error) {
                console.error('Server error fetching monthly weight:', weightData.error);
                $('#monthlyWeightChart').parent().html('<p class="text-center text-danger">Error al cargar datos de peso.</p>');
                return;
            }
            if (!Array.isArray(weightData) || weightData.length === 0) {
                 console.warn('No weight data received.');
                 $('#monthlyWeightChart').parent().html('<p class="text-center">No hay datos de peso disponibles para mostrar.</p>');
                 return;
            }

            createMonthlyWeightChart(weightData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly weight data:', error);
            $('#monthlyWeightChart').parent().html('<p class="text-center text-danger">Error al cargar datos para el gráfico de peso.</p>');
        }
    });

    function createMonthlyWeightChart(data) {
        var ctx = document.getElementById('monthlyWeightChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var weights = data.map(function(item) {
            return parseFloat(item.total_weight) || 0;
        });

        monthlyWeightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso Total Mensual (kg)',
                    data: weights,
                    backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning yellow
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(255, 193, 7, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Peso Total (kg)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + ' kg';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Peso Total: ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + ' kg';
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Peso Total Mensual Registrado',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header text-white" style="background-color: #6f42c1;"> <!-- Custom Purple -->
            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Indice de Conversión Alimentaria (Kg Alimento / Kg Peso Animal)</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyConversionChart"></canvas>
                 <div id="conversionChartMessage" class="text-center mt-3"></div> <!-- Message area -->
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Average Conversion Rate -->
<script>
$(document).ready(function() {
    let monthlyConversionChart = null;
    // URL for Numerator: Monthly Total Feed Weight (Projected)
    const feedWeightUrl = 'get_monthly_feed_weight_data.php'; 
    // URL for Denominator Calculation: Monthly Total Animal Weight
    const animalWeightUrl = 'get_monthly_weight_data.php'; 

    // Use Promise.all to fetch both datasets concurrently
    Promise.all([
        $.getJSON(feedWeightUrl), // Fetch total feed weight (Numerator)
        $.getJSON(animalWeightUrl) // Fetch total animal weight (for Denominator)
    ])
    .then(function([feedWeightData, animalWeightData]) {
        // --- Basic Error Handling --- 
        let hasError = false;
        if (!Array.isArray(feedWeightData) || feedWeightData.error) {
            console.error('Error or invalid format fetching feed weight data:', feedWeightData);
            $('#conversionChartMessage').html('<p class="text-danger">Error al cargar datos de peso de alimento.</p>');
            hasError = true;
        }
        if (!Array.isArray(animalWeightData) || animalWeightData.error) {
            console.error('Error or invalid format fetching animal weight data:', animalWeightData);
            $('#conversionChartMessage').append('<p class="text-danger">Error al cargar datos de peso animal.</p>');
             hasError = true;
        }
        if (hasError) return; // Stop if errors occurred

        if (feedWeightData.length === 0 || animalWeightData.length === 0) {
             console.warn('No data available for feed weight or animal weight to calculate FCR.');
             $('#conversionChartMessage').html('<p class="text-center">No hay suficientes datos para calcular la conversión (Kg Alimento / Kg Ganancia).</p>');
             return;
        }

        // --- Data Processing --- 
        const feedByMonth = {};
        feedWeightData.forEach(item => {
            feedByMonth[item.month] = parseFloat(item.total_feed_kg) || 0;
        });

        const weightByMonth = {};
        animalWeightData.forEach(item => {
            weightByMonth[item.month] = parseFloat(item.total_weight) || 0;
        });

        // Get all unique months present in *both* datasets and sort them
        const allMonths = [...new Set([...Object.keys(feedByMonth), ...Object.keys(weightByMonth)])].sort(); 

        const conversionData = [];

        for (let i = 0; i < allMonths.length; i++) {
            const currentMonth = allMonths[i];
            const currentFeedKg = feedByMonth[currentMonth] || 0;
            const currentWeightKg = weightByMonth[currentMonth] || 0;

            // Calculate Weight Gain (Denominator)
            let weightGain = 0;
             if (i > 0) {
                 const previousMonth = allMonths[i-1];
                 const previousWeightKg = weightByMonth[previousMonth] || 0;
                 // Ensure previous month data actually exists for calculation
                 if (weightByMonth.hasOwnProperty(previousMonth)) {
                    weightGain = currentWeightKg - previousWeightKg;
                 }
             } else {
                 // Cannot calculate gain for the very first month
                 continue; 
             }

            // Calculate Feed Conversion Ratio (FCR) (Kg Feed / Kg Gain)
            // Avoid division by zero or division when weight gain is zero or negative.
            const fcr = (weightGain > 0) ? (currentFeedKg / weightGain) : 0;

            // Only add data points where we have feed data for the current month 
            // AND positive weight gain calculated from the previous month.
            if (feedByMonth.hasOwnProperty(currentMonth) && weightGain > 0) {
                 conversionData.push({
                     month: currentMonth,
                     fcr: fcr // Indice (Kg Alimento / Kg Ganancia)
                 });
            }
        }
         
         if (conversionData.length === 0) {
             $('#conversionChartMessage').html('<p class="text-center">No se pudo calcular la conversión (quizás falta información de alimento o ganancia de peso positiva).</p>');
             return;
         }

        createMonthlyConversionChart(conversionData);
    })
    .catch(function(error) {
        console.error('Error fetching data for FCR chart:', error);
        $('#conversionChartMessage').html('<p class="text-center text-danger">Ocurrió un error al obtener los datos para el gráfico de conversión.</p>');
    });

    function createMonthlyConversionChart(data) {
        var ctx = document.getElementById('monthlyConversionChart').getContext('2d');

        // If chart exists, destroy it before creating a new one
        if (monthlyConversionChart) {
            monthlyConversionChart.destroy();
        }

        var labels = data.map(item => item.month);
        var rates = data.map(item => parseFloat(item.fcr)); 

        monthlyConversionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Indice Conversion Alimentaria (ICA)', // FCR Label
                    data: rates,
                    backgroundColor: 'rgba(111, 66, 193, 0.2)', // Purple
                    borderColor: 'rgba(111, 66, 193, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(111, 66, 193, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                         beginAtZero: true, // FCR is typically >= 0
                        title: {
                            display: true,
                            text: 'Indice (Kg Alimento / Kg Peso Animal)', // FCR Axis Label
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                // Format as a ratio 
                                return value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                // FCR Tooltip
                                return 'Indice: ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }); // Unitless ratio (kg/kg)
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Indice Conversion Alimentaria (Kg Alimento / Kg Peso Animal)', // ICA Title
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>