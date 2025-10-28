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
<title>Porcino - Registro de Sal</title>
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
  <h3  class="container mt-4 text-white" class="collapse" id="sal">
  REGISTROS DE SAL
  </h3>
    
  <!-- New Sal Entry Modal -->
  
  <div class="modal fade" id="newSalModal" tabindex="-1" aria-labelledby="newSalModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSalModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Sal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newSalForm">
                    <input type="hidden" name="id" id="new_id" value="">
                <div class="mb-4">
                        <label for="new_fecha" class="form-label">
                            <i class="fas fa-calendar me-2"></i>Fecha Inicio
                        </label>
                        <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_fecha_fin" class="form-label">
                            <i class="fas fa-calendar me-2"></i>Fecha Fin
                        </label>
                        <input type="date" class="form-control" id="new_fecha_fin" name="fecha_fin" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_tagid" class="form-label">
                            <i class="fas fa-tag me-2"></i>Tag ID
                        </label>
                        <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                    </div>                    
                    <div class="mb-4">
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
                    <div class="mb-4">
                        <label for="new_producto" class="form-label">
                            <i class="fa-solid fa-syringe me-2"></i>Sal
                        </label>
                        <select class="form-select" id="new_producto" name="producto" required>
                            <option value="">Productos</option>
                            <?php
                            try {
                                $sql_alimentos = "SELECT DISTINCT pc_sal_nombre FROM pc_sal ORDER BY pc_sal_nombre ASC";
                                $stmt_alimentos = $conn->prepare($sql_alimentos);
                                $stmt_alimentos->execute();
                                $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($alimentos as $alimento_row) {
                                    echo '<option value="' . htmlspecialchars($alimento_row['pc_sal_nombre']) . '">' . htmlspecialchars($alimento_row['pc_sal_nombre']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                error_log("Error fetching sals: " . $e->getMessage());
                                echo '<option value="">Error al cargar sals</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="new_racion" class="form-label">
                            <i class="fa-solid fa-weight me-2"></i>Racion
                        </label>
                        <input type="text" class="form-control" id="new_racion" name="racion" required>
                    </div>                    
                    <div class="mb-4">
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
                <button type="button" class="btn btn-success" id="saveNewSal">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for ph_sal records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">  
          <table id="salTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha Inicio</th>
                      <th class="text-center">Fecha Fin</th>
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
                      // Query to get all Animals and ALL their sal records (if any)
                        $salQuery = "
                            SELECT
                                b.tagid AS porcino_tagid,
                                b.nombre AS animal_nombre,
                                c.id AS sal_id,         -- Will be NULL for animals with no sal records
                                c.ph_sal_fecha_inicio,
                                c.ph_sal_fecha_fin,
                                c.ph_sal_tagid,         -- Matches porcino_tagid if sal exists
                                c.ph_sal_etapa,
                                c.ph_sal_producto,
                                c.ph_sal_racion,
                                c.ph_sal_costo,
                                -- Calculate total_value only if c.id is not null
                                CASE WHEN c.id IS NOT NULL THEN CAST((c.ph_sal_racion * c.ph_sal_costo) AS DECIMAL(10,2)) ELSE NULL END as total_value
                            FROM
                                porcino b
                            LEFT JOIN
                                ph_sal c ON b.tagid = c.ph_sal_tagid -- Join ALL matching sal records
                            ORDER BY
                                -- Prioritize animals with records (IS NOT NULL -> 0, IS NULL -> 1)
                                CASE WHEN c.id IS NOT NULL THEN 0 ELSE 1 END ASC,
                                -- Then order by animal tag ID to group them
                                b.tagid ASC,
                                -- Within each animal, order their sal records by date descending
                                c.ph_sal_fecha_inicio DESC";

                        $stmt = $conn->prepare($salQuery);
                        $stmt->execute();
                        $salData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($salData)) {
                          echo "<tr><td colspan='10' class='text-center'>No hay animales registrados</td></tr>"; // Message adjusted
                      } else {
                          // Get vigencia setting for sal records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT v_vencimiento_sal FROM v_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['v_vencimiento_sal'])) {
                                  $vigencia = intval($row['v_vencimiento_sal']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          
                          foreach ($salData as $row) {
                              $hasSal = !empty($row['sal_id']);
                              $salFecha = $row['ph_sal_fecha_inicio'] ?? null;

                              echo "<tr>";

                              // Column 1: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              // Always show Add Button
                              echo '        <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newSalModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                              title="Registrar Nuevo Sal">
                                              <i class="fas fa-plus"></i>
                                          </button>';
                              
                              if ($hasSal) {
                                  // Edit Button (only if sal exists)
                                  echo '        <button class="btn btn-warning btn-sm edit-sal" 
                                                  data-id="'.htmlspecialchars($row['sal_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                                  data-etapa="'.htmlspecialchars($row['ph_sal_etapa'] ?? '').'" 
                                                  data-producto="'.htmlspecialchars($row['ph_sal_producto'] ?? '').'" 
                                                  data-racion="'.htmlspecialchars($row['ph_sal_racion'] ?? '').'" 
                                                  data-costo="'.htmlspecialchars($row['ph_sal_costo'] ?? '').'" 
                                                  data-fecha="'.htmlspecialchars($salFecha ?? '').'" 
                                                  data-fecha_fin="'.htmlspecialchars($row['ph_sal_fecha_fin'] ?? '').'" 
                                                  title="Editar Registro">
                                                  <i class="fas fa-edit"></i>
                                              </button>';
                                  // Delete Button (only if sal exists)
                                  echo '        <button class="btn btn-danger btn-sm delete-sal" 
                                                  data-id="'.htmlspecialchars($row['sal_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['porcino_tagid'] ?? '').'" 
                                                  title="Eliminar Registro">
                                                  <i class="fas fa-trash"></i>
                                              </button>';
                              }
                              echo '    </div>';
                              echo '</td>';

                              // Column 2: Fecha Inicio (or N/A)
                              echo "<td>" . ($salFecha ? htmlspecialchars(date('d/m/Y', strtotime($salFecha))) : 'N/A') . "</td>";
                              // Column 3: Fecha Fin (or N/A)
                              $salFechaFin = $row['ph_sal_fecha_fin'] ?? null;
                              echo "<td>" . ($salFechaFin ? htmlspecialchars(date('d/m/Y', strtotime($salFechaFin))) : 'N/A') . "</td>";
                              // Column 4: Nombre Animal
                              echo "<td>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              // Column 5: Tag ID Animal
                              echo "<td>" . htmlspecialchars($row['porcino_tagid'] ?? 'N/A') . "</td>";
                              // Column 6: Etapa (or N/A)
                              echo "<td>" . ($hasSal ? htmlspecialchars($row['ph_sal_etapa'] ?? '') : 'N/A') . "</td>";
                              // Column 7: Producto (or N/A)
                              echo "<td>" . ($hasSal ? htmlspecialchars($row['ph_sal_producto'] ?? '') : 'N/A') . "</td>";
                              // Column 8: Racion (or N/A)
                              echo "<td>" . ($hasSal ? htmlspecialchars($row['ph_sal_racion'] ?? '') : 'N/A') . "</td>";
                              // Column 9: Costo (or N/A)
                              echo "<td>" . ($hasSal ? htmlspecialchars($row['ph_sal_costo'] ?? '') : 'N/A') . "</td>";
                              // Column 10: Valor Total (or N/A)
                              echo "<td>" . ($hasSal && isset($row['total_value']) ? htmlspecialchars($row['total_value']) : 'N/A') . "</td>";
                              
                              // Column 11: Estatus (or N/A)
                              if ($hasSal && $salFecha) {
                                  try {
                                      $salDate = new DateTime($salFecha);
                                      $dueDate = clone $salDate;
                                      $dueDate->modify("+{$vigencia} days");
                                      
                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $salFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  echo '<td class="text-center"><span class="badge bg-secondary">Sin Registro</span></td>'; // Status if no concentrado
                              }
                              
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in sal table: " . $e->getMessage());
                      echo "<tr><td colspan='10' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan to 10
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH Sal -->
<script>
$(document).ready(function() {
    $('#salTable').DataTable({
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
    var newSalModalEl = document.getElementById('newSalModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Sal Modal opens --- 
    if (newSalModalEl && tagIdInput) {
        newSalModalEl.addEventListener('show.bs.modal', function (event) {
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
        newSalModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newSalForm').removeClass('was-validated'); 
            document.getElementById('newSalForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---
    
    // Handle new entry form submission
    $('#saveNewSal').click(function() {
        // Validate the form
        var form = document.getElementById('newSalForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            racion: $('#new_racion').val(),
            etapa: $('#new_etapa').val(),
            producto: $('#new_producto').val(),
            costo: $('#new_costo').val(),
            fecha: $('#new_fecha').val(),
            fecha_fin: $('#new_fecha_fin').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el registro de sal ${formData.racion} kg para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_sal.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        racion: formData.racion,
                        etapa: formData.etapa,
                        producto: formData.producto,
                        costo: formData.costo,
                        fecha: formData.fecha,
                        fecha_fin: formData.fecha_fin
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newSalModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de sal ha sido guardado correctamente',
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
    $('.edit-sal').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var etapa = $(this).data('etapa');
        var producto = $(this).data('producto');
        var racion = $(this).data('racion');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        var fecha_fin = $(this).data('fecha_fin');
        
        // Edit Sal Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editSalModal" tabindex="-1" aria-labelledby="editSalModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSalModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Sal
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSalForm">
                            <input type="hidden" id="edit_id" value="${id}">                            
                            <div class="mb-4">
                                <label for="edit_fecha" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha Inicio
                                </label>
                                <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_fecha_fin" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha Fin
                                </label>
                                <input type="date" class="form-control" id="edit_fecha_fin" value="${fecha_fin}" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_tagid" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Tag ID
                                </label>
                                <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="edit_producto" class="form-label">
                                    <i class="fa-solid fa-syringe me-2"></i>Sal
                                </label>
                                <select class="form-select" id="edit_producto" name="producto" required>
                                    <option value="">Productos</option>
                                    <?php
                                    try {
                                        $sql_alimentos = "SELECT DISTINCT pc_sal_nombre FROM pc_sal ORDER BY pc_sal_nombre ASC";
                                        $stmt_alimentos = $conn->prepare($sql_alimentos);
                                        $stmt_alimentos->execute();
                                        $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alimentos as $alimento_row) {
                                            echo '<option value="' . htmlspecialchars($alimento_row['pc_sal_nombre']) . '">' . htmlspecialchars($alimento_row['pc_sal_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching sals: " . $e->getMessage());
                                        echo '<option value="">Error al cargar sals</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-4">
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
                            <div class="mb-4">
                                <label for="edit_racion" class="form-label">
                                    <i class="fas fa-weight me-2"></i>Racion (kg)
                                </label>
                                <input type="number" step="0.01" class="form-control" id="edit_racion" value="${racion}" required>
                            </div>
                            <div class="mb-4">
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
                        <button type="button" class="btn btn-success" id="saveEditSal">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editSalModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editSalModal'));
        editModal.show();
        
        // Set the selected values for dropdowns after modal is shown
        setTimeout(function() {
            $('#edit_producto').val(producto);
            $('#edit_etapa').val(etapa);
        }, 100);
        
        // Handle save button click
        $('#saveEditSal').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                racion: $('#edit_racion').val(),
                etapa: $('#edit_etapa').val(),
                producto: $('#edit_producto').val(),
                costo: $('#edit_costo').val(),
                fecha: $('#edit_fecha').val(),
                fecha_fin: $('#edit_fecha_fin').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el registro de sal para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_sal.php',
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
                            fecha_fin: formData.fecha_fin
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
    $('.delete-sal').click(function() {
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
                    url: 'process_sal.php',
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

<!-- Sal Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Gasto Total Mensual en Sal</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyExpenseSalChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let monthlyExpenseSalChart = null;

    // Fetch monthly expense data and create the chart
    $.ajax({
        url: 'get_salt_data.php?type=monthly_expense', // Updated endpoint with type parameter
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Received monthly expense sal data:', data); // Debug log
            
            if (data.error) {
                console.error('Server error fetching monthly expense sal:', data.error);
                $('#monthlyExpenseSalChart').parent().html('<div class="alert alert-danger">Error: ' + data.error + '</div>');
                return;
            }
            
            if (!data || data.length === 0) {
                console.log('No monthly expense sal data available');
                $('#monthlyExpenseSalChart').parent().html('<div class="alert alert-info">No hay datos de gastos mensuales disponibles para mostrar en el gráfico.</div>');
                return;
            }
            
            createMonthlyExpenseSalChart(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense sal data:', error);
            console.error('Response text:', xhr.responseText);
            $('#monthlyExpenseSalChart').parent().html('<div class="alert alert-danger">Error al cargar datos: ' + error + '</div>');
        }
    });

    function createMonthlyExpenseSalChart(data) {
        try {
            var ctx = document.getElementById('monthlyExpenseSalChart').getContext('2d');

            if (!data || data.length === 0) {
                console.log('No data to create monthly expense chart');
                return;
            }

            // Format the data for the chart
            var labels = data.map(function(item) {
                // Display month and year (YYYY-MM)
                return item.month;
            });

            var expenses = data.map(function(item) {
                return parseFloat(item.total_expense) || 0;
            });
            
            console.log('Monthly expense chart labels:', labels);
            console.log('Monthly expense chart data:', expenses);

        monthlyExpenseSalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Total Mensual Sal ($)',
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
                            text: 'Gasto Total Sal ($)',
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
                        text: 'Gasto Total Mensual en Sal',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
        } catch (error) {
            console.error('Error creating monthly expense sal chart:', error);
            $('#monthlyExpenseSalChart').parent().html('<div class="alert alert-danger">Error al crear el gráfico: ' + error.message + '</div>');
        }
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Gasto Acumulado Mensual en Sal
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="cumulativeExpenseSalChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Cumulative Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let cumulativeExpenseSalChart = null;

    // Fetch the SAME monthly expense data used for the total monthly chart
    $.ajax({
        url: 'get_salt_data.php?type=monthly_expense', // Using the updated endpoint with type parameter
        type: 'GET',
        dataType: 'json',
        success: function(monthlyData) {
            console.log('Received monthly data for cumulative chart:', monthlyData); // Debug log
            
            if (monthlyData.error) {
                console.error('Server error fetching monthly expense sal for cumulative chart:', monthlyData.error);
                $('#cumulativeExpenseSalChart').parent().html('<div class="alert alert-danger">Error: ' + monthlyData.error + '</div>');
                return;
            }
            if (!Array.isArray(monthlyData) || monthlyData.length === 0) {
                 console.warn('No monthly data sal received for cumulative chart.');
                 // Optionally display a message in the chart area
                 $('#cumulativeExpenseSalChart').parent().html('<div class="alert alert-info">No hay datos disponibles para mostrar el gasto acumulado.</div>');
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

            createCumulativeExpenseSalChart(cumulativeData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense sal data for cumulative chart:', error);
            console.error('Response text:', xhr.responseText);
            $('#cumulativeExpenseSalChart').parent().html('<div class="alert alert-danger">Error al cargar datos para el gráfico acumulado: ' + error + '</div>');
        }
    });

    function createCumulativeExpenseSalChart(data) {
        var ctx = document.getElementById('cumulativeExpenseSalChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var cumulativeExpenses = data.map(function(item) {
            return parseFloat(item.cumulative_expense) || 0;
        });

        cumulativeExpenseSalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Acumulado Mensual Sal ($)',
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
                            text: 'Gasto Acumulado Sal ($)',
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
                        text: 'Gasto Acumulado Mensual en Sal',
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
        <div class="card-header bg-success text-white"> <!-- Changed color for weight data -->
            <h5 class="mb-0"><i class="fas fa-weight-hanging me-2"></i>Promedio Peso Mensual de Animales</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyWeightSalChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Total Weight Line Chart -->
<script>
$(document).ready(function() {
    let monthlyWeightSalChart = null;

    // Fetch monthly average weight data from ph_peso table
    $.ajax({
        url: 'get_weight_data.php?type=monthly_average', // Updated endpoint to use weight data
        type: 'GET',
        dataType: 'json',
        success: function(weightData) {
            console.log('Received monthly average weight data:', weightData); // Debug log
            
            if (weightData.error) {
                console.error('Server error fetching monthly average weight:', weightData.error);
                $('#monthlyWeightSalChart').parent().html('<div class="alert alert-danger">Error al cargar datos de peso: ' + weightData.error + '</div>');
                return;
            }
            if (!Array.isArray(weightData) || weightData.length === 0) {
                 console.warn('No average weight data received.');
                 $('#monthlyWeightSalChart').parent().html('<div class="alert alert-info">No hay datos de peso promedio disponibles para mostrar.</div>');
                 return;
            }

            createMonthlyWeightSalChart(weightData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly average weight data:', error);
            console.error('Response text:', xhr.responseText);
            $('#monthlyWeightSalChart').parent().html('<div class="alert alert-danger">Error al cargar datos para el gráfico de peso promedio: ' + error + '</div>');
        }
    });

    function createMonthlyWeightSalChart(data) {
        var ctx = document.getElementById('monthlyWeightSalChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var weights = data.map(function(item) {
            return parseFloat(item.average_weight) || 0;
        });

        monthlyWeightSalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso Promedio Mensual (kg)',
                    data: weights,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success green
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
                            text: 'Peso Promedio (kg)',
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
                                return 'Peso Promedio: ' + context.parsed.y.toLocaleString('es-ES', {
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
                        text: 'Promedio de Peso Mensual de Animales',
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
                <canvas id="monthlyConversionSalChart"></canvas>
                 <div id="conversionSalChartMessage" class="text-center mt-3"></div> <!-- Message area -->
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Average Conversion Rate -->
<script>
$(document).ready(function() {
    let monthlyConversionSalChart = null;
    // URL for Numerator: Monthly Total Feed Weight from salt data
    const feedWeightUrl = 'get_salt_data.php?type=monthly_feed_weight'; 
    // URL for Denominator Calculation: Monthly Average Animal Weight from actual weight records
    const animalWeightUrl = 'get_weight_data.php?type=monthly_average'; 

    // Use Promise.all to fetch both datasets concurrently
    Promise.all([
        $.getJSON(feedWeightUrl), // Fetch total feed weight (Numerator)
        $.getJSON(animalWeightUrl) // Fetch total animal weight (for Denominator)
    ])
    .then(function([feedWeightData, animalWeightData]) {
        console.log('Received feed weight data:', feedWeightData); // Debug log
        console.log('Received animal weight data:', animalWeightData); // Debug log
        
        // --- Basic Error Handling --- 
        let hasError = false;
        if (!Array.isArray(feedWeightData) || feedWeightData.error) {
            console.error('Error or invalid format fetching feed weight data:', feedWeightData);
            $('#conversionSalChartMessage').html('<div class="alert alert-danger">Error al cargar datos de peso de alimento: ' + (feedWeightData.error || 'Datos inválidos') + '</div>');
            hasError = true;
        }
        if (!Array.isArray(animalWeightData) || animalWeightData.error) {
            console.error('Error or invalid format fetching animal weight data:', animalWeightData);
            $('#conversionSalChartMessage').append('<div class="alert alert-danger">Error al cargar datos de peso animal: ' + (animalWeightData.error || 'Datos inválidos') + '</div>');
             hasError = true;
        }
        if (hasError) return; // Stop if errors occurred

        if (feedWeightData.length === 0 || animalWeightData.length === 0) {
             console.warn('No data available for feed weight or animal weight to calculate FCR.');
             $('#conversionSalChartMessage').html('<div class="alert alert-info">No hay suficientes datos para calcular la conversión (Kg Alimento / Kg Peso Animal).</div>');
             return;
        }

        // --- Data Processing --- 
        const feedByMonth = {};
        feedWeightData.forEach(item => {
            feedByMonth[item.month] = parseFloat(item.total_feed_kg) || 0;
        });

        const weightByMonth = {};
        animalWeightData.forEach(item => {
            weightByMonth[item.month] = parseFloat(item.average_weight) || 0;
        });

        // Get all unique months present in *both* datasets and sort them
        const allMonths = [...new Set([...Object.keys(feedByMonth), ...Object.keys(weightByMonth)])].sort(); 

        const conversionData = [];

        for (let i = 0; i < allMonths.length; i++) {
            const currentMonth = allMonths[i];
            const currentFeedKg = feedByMonth[currentMonth] || 0;
            const currentWeightKg = weightByMonth[currentMonth] || 0;

            // Calculate Feed Conversion Ratio (FCR) as Kg Feed / Kg Average Weight
            // This gives us a ratio of how much feed is consumed relative to animal weight
            // Avoid division by zero
            const fcr = (currentWeightKg > 0) ? (currentFeedKg / currentWeightKg) : 0;

            // Only add data points where we have both feed and weight data for the current month
            if (feedByMonth.hasOwnProperty(currentMonth) && 
                weightByMonth.hasOwnProperty(currentMonth) && 
                currentFeedKg > 0 && currentWeightKg > 0) {
                 conversionData.push({
                     month: currentMonth,
                     fcr: fcr, // Indice (Kg Alimento / Kg Peso Promedio)
                     feedKg: currentFeedKg,
                     weightKg: currentWeightKg
                 });
            }
        }
         
         if (conversionData.length === 0) {
             $('#conversionSalChartMessage').html('<div class="alert alert-warning">No se pudo calcular la conversión (falta información de alimento o peso de animales).</div>');
             return;
         }

        createMonthlyConversionChart(conversionData);
    })
    .catch(function(error) {
        console.error('Error fetching data for FCR chart:', error);
        $('#conversionSalChartMessage').html('<div class="alert alert-danger">Ocurrió un error al obtener los datos para el gráfico de conversión: ' + error + '</div>');
    });

    function createMonthlyConversionChart(data) {
        var ctx = document.getElementById('monthlyConversionSalChart').getContext('2d');

        // If chart exists, destroy it before creating a new one
        if (monthlyConversionSalChart) {
            monthlyConversionSalChart.destroy();
        }

        var labels = data.map(item => item.month);
        var rates = data.map(item => parseFloat(item.fcr)); 

        monthlyConversionSalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Indice Conversion Alimentaria Sal (ICA)', // FCR Label
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
                            text: 'Indice Sal (Kg Alimento / Kg Peso Animal)', // FCR Axis Label
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
                        text: 'Indice Conversion Alimentaria Sal (Kg Alimento / Kg Peso Animal)', // ICA Title
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