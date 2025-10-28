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
<title>Porcino Register Descarte</title>
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
                        <span class="badge-active">🎯 Registrando Descartes</span>
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

  
  <!-- New Descarte Entry Modal -->
  
  <div class="modal fade" id="newDescarteModal" tabindex="-1" aria-labelledby="newDescarteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDescarteModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Descarte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newDescarteForm">
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
                                <input type="text" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="new_precio" name="precio" required>
                            </span>                            
                        </div>
                    </div>                                                                                 
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewDescarte">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for Discarded Animals (estatus = Descartado) -->
  <div class="container table-section mb-5">
      <div class="card shadow">
          <div class="card-header bg-warning text-dark">
              <h5 class="mb-0"><i class="fas fa-weight me-2"></i>Animales Descartados</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="discardedAnimalsTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th class="text-center">Imagen</th>
                              <th class="text-center">Acciones</th>
                              <th class="text-center">Fecha Descarte</th>
                              <th class="text-center">Nombre</th>                    
                              <th class="text-center">Tag ID</th>
                              <th class="text-center">Peso (Kg)</th>                      
                              <th class="text-center">Precio ($)</th>                      
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          try {
                            // Query to get discarded animals only (estatus = Descartado) - ensure we have discard data
                            $discardedQuery = "SELECT * FROM porcino WHERE estatus = 'Descartado' AND descarte_fecha IS NOT NULL AND descarte_peso IS NOT NULL AND descarte_precio IS NOT NULL ORDER BY descarte_fecha DESC";                              
                            $stmt = $conn->prepare($discardedQuery);  
                            $stmt->execute();
                            $discardedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            // If no data, display a message
                            if (empty($discardedData)) {
                                echo "<tr><td colspan='7' class='text-center'>No hay animales descartados con información completa</td></tr>";
                            } else {
                                foreach ($discardedData as $row) {
                                    echo "<tr>";
                                    
                                    // Add image column as the first column
                                    echo '<td class="text-center">';
                                    // Check if animal has an image
                                    if (!empty($row['image'])) {
                                        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                    } else {
                                        echo '<img src="images/cerdo-poblacion.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                    }
                                    echo '</td>';
                                    
                                    // Add action buttons (edit and delete)
                                    echo '<td class="text-center">
                                        <div class="btn-group" role="group">';
                                    
                                    // Show edit button for all discarded animals (they should have discard information)
                                    echo '<button class="btn btn-warning btn-sm edit-descarte" 
                                            data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                            data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '"
                                            data-fecha="' . htmlspecialchars($row['descarte_fecha'] ?? '') . '"
                                            data-peso="' . htmlspecialchars($row['descarte_peso'] ?? '') . '"
                                            data-precio="' . htmlspecialchars($row['descarte_precio'] ?? '') . '">
                                            <i class="fas fa-edit"></i>
                                        </button>';
                                    
                                    echo '<button class="btn btn-danger btn-sm delete-descarte" 
                                            data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                            <i class="fas fa-trash"></i>
                                        </button>';
                                    echo '</div>
                                    </td>';
                                    
                                    echo "<td class='text-center'>" . htmlspecialchars($row['descarte_fecha'] ?? '') . "</td>";                        
                                    echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['descarte_peso'] ?? '') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['descarte_precio'] ?? '') . "</td>";
                                    echo "</tr>";
                                }
                            }
                          } catch (PDOException $e) {
                            error_log("Error in discarded animals table: " . $e->getMessage());
                            echo "<tr><td colspan='7' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                          }
                          ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

  <!-- DataTable for Available Animals (estatus = Activo) -->
  <div class="container table-section mb-5">
      <div class="card shadow">
          <div class="card-header bg-primary text-white">
              <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Animales Disponibles</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="availableAnimalsTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th class="text-center">Imagen</th>
                              <th class="text-center">Acciones</th>
                              <th class="text-center">Nombre</th>                      
                              <th class="text-center">Fecha Nacimiento</th>                  
                              <th class="text-center">Tag ID</th>
                              <th class="text-center">Raza</th>
                              <th class="text-center">Etapa</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          try {
                            // Query to get available animals (estatus = Activo)
                            $availableQuery = "SELECT * FROM porcino WHERE estatus = 'Activo' ORDER BY nombre ASC";                              
                            $stmt = $conn->prepare($availableQuery);  
                            $stmt->execute();
                            $availableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            // If no data, display a message
                            if (empty($availableData)) {
                                echo "<tr><td colspan='7' class='text-center'>No hay animales disponibles</td></tr>";
                            } else {
                                foreach ($availableData as $row) {
                                    echo "<tr>";
                                    
                                    // Add image column as the first column
                                    echo '<td class="text-center">';
                                    // Check if animal has an image
                                    if (!empty($row['image'])) {
                                        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                    } else {
                                        echo '<img src="images/cerdo-poblacion.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                    }
                                    echo '</td>';
                                    
                                    // Add action buttons (register discard button only)
                                    echo '<td class="text-center">
                                        <div class="btn-group" role="group">';
                                    
                                    // Show register discard button for available animals
                                    echo '<button class="btn btn-success btn-sm register-descarte" 
                                            data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '">
                                            <i class="fas fa-plus"></i>
                                        </button>';
                                    
                                    echo '</div>
                                    </td>';
                                    
                                    echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['fecha_nacimiento'] ?? '') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['raza'] ?? '') . "</td>";
                                    echo "<td class='text-center'>" . htmlspecialchars($row['etapa'] ?? '') . "</td>";
                                    echo "</tr>";
                                }
                            }
                          } catch (PDOException $e) {
                            error_log("Error in available animals table: " . $e->getMessage());
                            echo "<tr><td colspan='7' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                          }
                          ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Initialize DataTables for both tables -->
<script>
$(document).ready(function() {
    // Initialize DataTable for Discarded Animals
    $('#discardedAnimalsTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[2, 'desc']],
        
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
                targets: [2], // Fecha Descarte column
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
                targets: [0, 1], // Image and Actions columns
                orderable: false,
                searchable: false
            }
        ]
    });

    // Initialize DataTable for Available Animals
    $('#availableAnimalsTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by nombre (name) column ascending
        order: [[2, 'asc']],
        
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
                targets: [3], // Fecha Nacimiento column
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
                targets: [0, 1], // Image and Actions columns
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
    // Add handler for register-descarte button
    $('.register-descarte').click(function() {
        var tagid = $(this).data('tagid');
        
        // Populate the tagid field in the newDescarteModal
        $('#new_tagid').val(tagid);
        
        // Show the modal
        var newDescarteModal = new bootstrap.Modal(document.getElementById('newDescarteModal'));
        newDescarteModal.show();
    });

    // Handle new entry form submission
    $('#saveNewDescarte').click(function() {
        // Validate the form
        var form = document.getElementById('newDescarteForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            peso: $('#new_peso').val(),
            precio: $('#new_precio').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el descarte para el animal con Tag ID ${formData.tagid}? Esto marcará el animal como "Descartado".`,
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
                
                // Log the data being sent
                console.log('Sending AJAX request with data:', {
                    action: 'insert',
                    tagid: formData.tagid,
                    peso: formData.peso,
                    precio: formData.precio,
                    fecha: formData.fecha
                });
                
                // Send AJAX request to insert the record
                $.ajax({
                    url: 'process_descarte.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        peso: formData.peso,
                        precio: formData.precio,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Log the response
                        console.log('AJAX Success Response:', response);
                        
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newDescarteModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de descarte ha sido guardado correctamente',
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
    $('.edit-descarte').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var peso = $(this).data('peso');
        var precio = $(this).data('precio');
        var fecha = $(this).data('fecha');
        
        // Edit Descarte Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editDescarteModal" tabindex="-1" aria-labelledby="editDescarteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDescarteModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Dosis de Descarte
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDescarteForm">
                            <input type="hidden" id="edit_id" value="${id}">
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
                                        <i class="fa-solid fa-weight"></i>
                                        <label for="edit_peso" class="form-label">Peso</label>                                    
                                        <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                        <label for="edit_precio" class="form-label">Precio</label>                                    
                                        <input type="text" class="form-control" id="edit_precio" value="${precio}" required>
                                    </span>                                    
                                </div>
                            </div>                                                 
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditDescarte">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editDescarteModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editDescarteModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditDescarte').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                peso: $('#edit_peso').val(),
                precio: $('#edit_precio').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el descarte para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_descarte.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            peso: formData.peso,
                            precio: formData.precio,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'El descarte para el animal con Tag ID ${formData.tagid} ha sido actualizado correctamente',
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
    $('.delete-descarte').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar descarte?',
            text: `¿Está seguro de que desea eliminar el descarte para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                    url: 'process_descarte.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El descarte para el animal con Tag ID ${tagid} ha sido eliminado correctamente',
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

<!-- Descarte Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución de Descartes</h5>
        </div>
        <div class="card-body">
            <!-- Using data directly from porcino table instead of bh_descarte -->
            <div class="row mb-4">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <label for="dataRangeFilter" class="form-label">Período de Tiempo:</label>
                    <select id="dataRangeFilter" class="form-select">
                        <option value="all">Todos los meses</option>
                        <option value="12" selected>Últimos 12 meses</option>
                        <option value="6">Últimos 6 meses</option>
                        <option value="3">Últimos 3 meses</option>
                    </select>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="descarteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Descarte Line Chart -->
<script>
$(document).ready(function() {
    let allDescarteData = [];
    let descarteChart = null;
    
    // Fetch discount data and create the chart
    $.ajax({
        url: 'get_descarte_monthly_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error('Server error:', response.message);
                $('#descarteChart').after('<div class="alert alert-danger">Error al cargar datos: ' + response.message + '</div>');
                return;
            }
            
            // Debug data received from server
            console.log('Monthly Descarte data received:', response);
            
            if (!response.data || response.data.length === 0) {
                console.warn('No descarte data received from server');
                $('#descarteChart').after('<div class="alert alert-warning">No hay datos de descartes disponibles.</div>');
                return;
            }
            
            // Log data structure to help with debugging
            if (response.data.length > 0) {
                console.log('Sample month data:', response.data[0]);
            }
            
            allDescarteData = response.data;
            createDescarteChart(response.data);
            
            // Add event listener for the data range filter
            $('#dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching descarte data:', error);
            $('#descarteChart').after('<div class="alert alert-danger">Error al cargar datos de descartes: ' + error + '</div>');
        }
    });
    
    function updateChart() {
        const selectedRange = $('#dataRangeFilter').val();
        
        let filteredData = [...allDescarteData];
        
        // Sort data by date (though it should already be sorted)
        filteredData.sort((a, b) => a.month_year.localeCompare(b.month_year));
        
        // Apply range filter to months
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            // Keep only the most recent X months
            filteredData = filteredData.slice(-parseInt(selectedRange));
        }
        
        // Check if we have data after filtering
        if (filteredData.length === 0) {
            if (descarteChart) {
                descarteChart.destroy();
                descarteChart = null;
            }
            $('.alert').remove();
            $('#descarteChart').after('<div class="alert alert-warning">No hay datos para el período seleccionado.</div>');
            return;
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (descarteChart) {
            descarteChart.destroy();
        }
        $('.alert').remove(); // Remove any previous alert messages
        createDescarteChart(data);
    }
    
    function createDescarteChart(data) {
        var ctx = document.getElementById('descarteChart').getContext('2d');
        
        // Extract the data for the chart
        var months = data.map(item => item.display_date);
        var totalValues = data.map(item => item.total_value);
        var animalCounts = data.map(item => item.discount_count);
        
        // Create the chart
        descarteChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Valor Total de Descartes',
                        data: totalValues,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Número de Animales',
                        data: animalCounts,
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderDash: [5, 5],
                        tension: 0.3,
                        fill: false,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor Total ($)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false // only show grid for the left y-axis
                        },
                        title: {
                            display: true,
                            text: 'Número de Animales',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes/Año',
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
                                const index = context.dataIndex;
                                const monthData = data[index];
                                
                                if (!monthData) return [];
                                
                                // Different formatting based on dataset
                                if (context.datasetIndex === 0) {
                                    // Value dataset
                                    return 'Valor Total: $' + monthData.total_value.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                } else {
                                    // Count dataset
                                    return 'Número de Animales: ' + monthData.discount_count;
                                }
                            },
                            afterBody: function(context) {
                                const index = context[0].dataIndex;
                                const monthData = data[index];
                                
                                if (!monthData || !monthData.animal_details || monthData.animal_details.length === 0) return [];
                                
                                const lines = ['───────────────────', 'Detalle de Animales:'];
                                
                                // Show up to 5 animals in the tooltip with their values
                                const detailsToShow = monthData.animal_details.slice(0, 5);
                                
                                detailsToShow.forEach(animal => {
                                    const animalName = animal.nombre || 'Sin nombre';
                                    const animalValue = animal.value.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                    
                                    lines.push(`${animalName} (${animal.tagid}): $${animalValue}`);
                                });
                                
                                // If there are more than 5 animals, indicate there are more
                                if (monthData.animal_details.length > 5) {
                                    lines.push(`... y ${monthData.animal_details.length - 5} más`);
                                }
                                
                                // Add average data
                                lines.push('───────────────────');
                                lines.push(`Valor Promedio: $${monthData.average_value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}`);
                                
                                return lines;
                            },
                            title: function(context) {
                                return 'Mes: ' + context[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Valor de Descartes Mensuales (precio × peso)',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            }
        });
    }
});
</script>