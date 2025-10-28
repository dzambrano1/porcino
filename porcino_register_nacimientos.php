<?php
require_once './pdo_conexion.php';

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}

// --- Prepare data for Monthly Birth Count Chart ---
try {
    $sqlMonthlyBirths = "SELECT 
                           DATE_FORMAT(fecha_nacimiento, '%Y-%m') as month, 
                           COUNT(*) as count 
                         FROM porcino 
                         WHERE fecha_nacimiento IS NOT NULL 
                         GROUP BY month 
                         ORDER BY month ASC";
    $stmtMonthlyBirths = $conn->prepare($sqlMonthlyBirths);
    $stmtMonthlyBirths->execute();
    $monthlyBirthData = $stmtMonthlyBirths->fetchAll(PDO::FETCH_ASSOC);

    $monthlyBirthLabels = [];
    $monthlyBirthCounts = [];
    foreach ($monthlyBirthData as $row) {
        $monthlyBirthLabels[] = $row['month'];
        $monthlyBirthCounts[] = (int)$row['count']; // Ensure count is integer
    }

    $monthlyBirthLabelsJson = json_encode($monthlyBirthLabels);
    $monthlyBirthCountsJson = json_encode($monthlyBirthCounts);

} catch (PDOException $e) {
    error_log("Error fetching monthly birth data: " . $e->getMessage());
    // Initialize empty arrays in case of error to prevent JS errors
    $monthlyBirthLabelsJson = json_encode([]);
    $monthlyBirthCountsJson = json_encode([]);
}
// --- End Monthly Birth Count Chart Data ---

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Porcino Register Nacimientos</title>
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

<!-- Professional Button Styling -->
<style>
.professional-button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem 0;
}

.btn-professional-register {
    position: relative;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 50px;
    padding: 0;
    width: 280px;
    height: 70px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
    cursor: pointer;
}

.btn-professional-register:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(40, 167, 69, 0.6);
}

.btn-professional-register:active {
    transform: translateY(-2px) scale(0.98);
}

.button-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 0 2rem;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-right: 1rem;
    transition: all 0.3s ease;
}

.btn-professional-register:hover .icon-wrapper {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.icon-wrapper i {
    font-size: 1.2rem;
    color: white;
}

.button-text {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.button-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.btn-professional-register:hover .button-glow {
    left: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-professional-register {
        width: 240px;
        height: 60px;
    }
    
    .button-content {
        font-size: 1rem;
        padding: 0 1.5rem;
    }
    
    .icon-wrapper {
        width: 35px;
        height: 35px;
        margin-right: 0.8rem;
    }
    
    .icon-wrapper i {
        font-size: 1.1rem;
    }
}

@media (max-width: 480px) {
    .btn-professional-register {
        width: 200px;
        height: 55px;
    }
    
    .button-content {
        font-size: 0.9rem;
        padding: 0 1rem;
    }
    
    .icon-wrapper {
        width: 30px;
        height: 30px;
        margin-right: 0.6rem;
    }
    
    .icon-wrapper i {
        font-size: 1rem;
    }
}

/* Animation for page load */
.professional-button-container {
    animation: fadeInUp 0.8s ease-out 0.3s both;
}
</style>
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
                        <span class="badge-active">🎯 Registrando Nacimientos</span>
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

  
  <div class="container mt-4 mb-5 text-center">
    <div class="professional-button-container">
        <button type="button" class="btn btn-professional-register" data-bs-toggle="modal" data-bs-target="#newEntryModal">
            <div class="button-content">
                <div class="icon-wrapper">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span class="button-text">Registrar</span>
            </div>
            <div class="button-glow"></div>
        </button>
    </div>
</div>
  
<!-- New Entry Modal -->
<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="newEntryModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Registrar Nacimiento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newEntryForm" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column - Images and Video -->
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <!-- Image slider for previews -->
                                <div id="newImagePreviewCarousel" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel" data-bs-interval="5200">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img id="newImagePreview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="newImage2Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="newImage3Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <video id="newVideoPreview" class="img-thumbnail" controls 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                                <source src="" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#newImagePreviewCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#newImagePreviewCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <!-- Upload buttons -->
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-1">
                                        <label for="newImageUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 1
                                        </label>
                                        <input type="file" class="d-none" id="newImageUpload" name="image"
                                               accept="image/*" onchange="previewImage(event, 'newImagePreview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newImage2Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 2
                                        </label>
                                        <input type="file" class="d-none" id="newImage2Upload" name="image2"
                                               accept="image/*" onchange="previewImage(event, 'newImage2Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newImage3Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 3
                                        </label>
                                        <input type="file" class="d-none" id="newImage3Upload" name="image3"
                                               accept="image/*" onchange="previewImage(event, 'newImage3Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newVideoUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-video me-1"></i>Video
                                        </label>
                                        <input type="file" class="d-none" id="newVideoUpload" name="video"
                                               accept="video/*" onchange="previewVideo(event, 'newVideoPreview')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Form Fields -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Tag ID -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="tagid" id="newTagid" required>
                                        <label for="newTagid">Tag ID</label>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un Tag ID válido.
                                        </div>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nombre" id="newNombre" required>
                                        <label for="newNombre">Nombre</label>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un nombre.
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="newFechaNacimiento" required>
                                        <label for="newFechaNacimiento">Fecha de Nacimiento</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione una fecha de nacimiento.
                                        </div>
                                    </div>
                                </div>
                               
                                <!-- Sexo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="genero" id="newGenero" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Macho">Macho</option>
                                            <option value="Hembra">Hembra</option>
                                        </select>
                                        <label for="newGenero">Sexo</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un sexo.
                                        </div>
                                    </div>
                                </div>

                                <!-- Raza -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="raza" id="newRaza" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_razas = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_razas = "SELECT DISTINCT pc_razas_nombre FROM pc_razas ORDER BY pc_razas_nombre";
                                            $result_razas = $conn_razas->query($sql_razas);
                                            while ($row_razas = $result_razas->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_razas['pc_razas_nombre']) . '">' 
                                                    . htmlspecialchars($row_razas['pc_razas_nombre']) . '</option>';
                                            }
                                            $conn_razas->close();
                                            ?>
                                        </select>
                                        <label for="newRaza">Raza</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione una raza.
                                        </div>
                                    </div>
                                </div>                                

                                <!-- Grupo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="grupo" id="newGrupo" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_grupos = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_grupos = "SELECT DISTINCT pc_grupos_nombre FROM pc_grupos ORDER BY pc_grupos_nombre";
                                            $result_grupos = $conn_grupos->query($sql_grupos);
                                            while ($row_grupos = $result_grupos->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_grupos['pc_grupos_nombre']) . '">' 
                                                    . htmlspecialchars($row_grupos['pc_grupos_nombre']) . '</option>';
                                            }
                                            $conn_grupos->close();
                                            ?>
                                        </select>
                                        <label for="newGrupo">Grupo</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un grupo.
                                        </div>
                                    </div>
                                </div>

                                <!-- Estatus -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="estatus" id="newEstatus" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_estatus = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_estatus = "SELECT DISTINCT pc_estatus_nombre FROM pc_estatus ORDER BY pc_estatus_nombre";
                                            $result_estatus = $conn_estatus->query($sql_estatus);
                                            while ($row_estatus = $result_estatus->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_estatus['pc_estatus_nombre']) . '">' 
                                                    . htmlspecialchars($row_estatus['pc_estatus_nombre']) . '</option>';
                                            }
                                            $conn_estatus->close();
                                            ?>
                                        </select>
                                        <label for="newEstatus">Estatus</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un estatus.
                                        </div>
                                    </div>
                                </div>
                                <!-- Peso -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.1" class="form-control" name="peso" id="newPeso" required>
                                        <label for="newPeso">Peso</label>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un peso.
                                        </div>
                                    </div>
                                </div>
                                <!-- Add hidden input for etapa -->
                                <input type="hidden" name="etapa" value="Inicio">
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" form="newEntryForm">
                    <i class="fas fa-save me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to preview image
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(previewId);
            if (output) {
                output.src = reader.result;
            }            
            // Show the correct carousel item
            const carouselItems = document.querySelectorAll('#newImagePreviewCarousel .carousel-item');
            carouselItems.forEach((item, index) => {
                if (item.querySelector('img') && item.querySelector('img').id === previewId) {
                    const carousel = bootstrap.Carousel.getInstance(document.getElementById('newImagePreviewCarousel'));
                    if (carousel) {
                        carousel.to(index);
                    }
                }
            });
        };
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Function to preview video
    function previewVideo(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(previewId);
            if (output) {
                const source = output.querySelector('source');
                if (source) {
                    source.src = reader.result;
                    output.load();
                }
                
                // Show video carousel item (last item)
                const carousel = bootstrap.Carousel.getInstance(document.getElementById('newImagePreviewCarousel'));
                if (carousel) {
                    const carouselItems = document.querySelectorAll('#newImagePreviewCarousel .carousel-item');
                    carousel.to(carouselItems.length - 1);
                }
            }
        };
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Initialize NewEntryModal form submission
    document.addEventListener('DOMContentLoaded', function() {
        // Get form element
        const createEntryForm = document.getElementById('newEntryForm');
        const newEntryModal = document.getElementById('newEntryModal');

        if (createEntryForm) {
            // Handle form submission
            createEntryForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                
                // Check form validation
                if (!createEntryForm.checkValidity()) {
                    event.stopPropagation();
                    createEntryForm.classList.add('was-validated');
                    return;
                }

                // Create a FormData object from the form
                const formData = new FormData(createEntryForm);

                // Show loading state
                const submitButton = document.querySelector('#newEntryModal .btn-success');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
                submitButton.disabled = true;

                // Send the form data using fetch
                fetch('porcino_nacimientos_create.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Nuevo animal agregado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Reset form and close modal
                            createEntryForm.reset();
                            createEntryForm.classList.remove('was-validated');
                            
                            // Reset image previews
                            document.getElementById('newImagePreview').src = './images/default_image.png';
                            document.getElementById('newImage2Preview').src = './images/default_image.png';
                            document.getElementById('newImage3Preview').src = './images/default_image.png';
                            const videoPreview = document.getElementById('newVideoPreview');
                            if (videoPreview && videoPreview.querySelector('source')) {
                                videoPreview.querySelector('source').src = '';
                                videoPreview.load();
                            }
                            
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(newEntryModal);
                            if (modal) {
                                modal.hide();
                            }
                            
                            // Reload page to show new entry
                            location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Ocurrió un error al agregar el nuevo animal.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud.'
                    });
                })
                .finally(() => {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
            });
        }

        // Initialize carousel when modal is shown
        newEntryModal.addEventListener('shown.bs.modal', function() {
            new bootstrap.Carousel(document.getElementById('newImagePreviewCarousel'), {
                interval: 5200
            });
        });
    });
</script>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="updateModalLabel">
                    <i class="fas fa-edit me-2"></i>Actualizar Nacimientos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column - Images and Video -->
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <!-- Image slider for previews -->
                                <div id="updateImagePreviewCarousel" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel" data-bs-interval="5200">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img id="updateImagePreview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="updateImage2Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="updateImage3Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <video id="updateVideoPreview" class="img-thumbnail" controls 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreenVideo(this)">
                                                <source src="" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#updateImagePreviewCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#updateImagePreviewCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <!-- Upload buttons -->
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-1">
                                        <label for="updateImageUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 1
                                        </label>
                                        <input type="file" class="d-none" id="updateImageUpload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImagePreview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateImage2Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 2
                                        </label>
                                        <input type="file" class="d-none" id="updateImage2Upload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImage2Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateImage3Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 3
                                        </label>
                                        <input type="file" class="d-none" id="updateImage3Upload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImage3Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateVideoUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-video me-1"></i>Video
                                        </label>
                                        <input type="file" class="d-none" id="updateVideoUpload" 
                                               accept="video/*" onchange="previewVideo(event, 'updateVideoPreview')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Form Fields -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Tag ID -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="tagid" id="updateTagid" required readonly>
                                        <label for="updateTagid">Tag ID</label>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nombre" id="updateNombre" required>
                                        <label for="updateNombre">Nombre</label>
                                    </div>
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="updateFechaNacimiento" required>
                                        <label for="updateFechaNacimiento">Fecha de Nacimiento</label>
                                    </div>
                                </div>                               

                                <!-- Sexo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="genero" id="updateGenero" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Macho">Macho</option>
                                            <option value="Hembra">Hembra</option>
                                        </select>
                                        <label for="updateGenero">Sexo</label>
                                    </div>
                                </div>

                                <!-- Raza -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="raza" id="updateRaza" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_razas = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_razas = "SELECT DISTINCT pc_razas_nombre FROM pc_razas ORDER BY pc_razas_nombre";
                                            $result_razas = $conn_razas->query($sql_razas);
                                            while ($row_razas = $result_razas->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_razas['pc_razas_nombre']) . '">' 
                                                    . htmlspecialchars($row_razas['pc_razas_nombre']) . '</option>';
                                            }
                                            $conn_razas->close();
                                            ?>
                                        </select>
                                        <label for="updateRaza">Raza</label>
                                    </div>
                                </div>                                

                                <!-- Add hidden input for etapa -->
                                <input type="hidden" name="etapa" value="Inicio">

                                <!-- Grupo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="grupo" id="updateGrupo" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_grupos = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_grupos = "SELECT DISTINCT pc_grupos_nombre FROM pc_grupos ORDER BY pc_grupos_nombre";
                                            $result_grupos = $conn_grupos->query($sql_grupos);
                                            while ($row_grupos = $result_grupos->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_grupos['pc_grupos_nombre']) . '">' 
                                                    . htmlspecialchars($row_grupos['pc_grupos_nombre']) . '</option>';
                                            }
                                            $conn_grupos->close();
                                            ?>
                                        </select>
                                        <label for="updateGrupo">Grupo</label>
                                    </div>
                                </div>

                                <!-- Estatus -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="estatus" id="updateEstatus" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $conn_estatus = new mysqli('localhost', $username, $password, $dbname);
                                            $sql_estatus = "SELECT DISTINCT pc_estatus_nombre FROM pc_estatus ORDER BY pc_estatus_nombre";
                                            $result_estatus = $conn_estatus->query($sql_estatus);
                                            while ($row_estatus = $result_estatus->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row_estatus['pc_estatus_nombre']) . '">' 
                                                    . htmlspecialchars($row_estatus['pc_estatus_nombre']) . '</option>';
                                            }
                                            $conn_estatus->close();
                                            ?>
                                        </select>
                                        <label for="updateEstatus">Estatus</label>
                                    </div>
                                </div>                                                        
                                <!-- Peso -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.1" class="form-control" name="peso" id="updatePeso" required>
                                        <label for="updatePeso">Peso</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-outline-success" onclick="saveUpdates()">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Save Update Modal -->
<script>
function saveUpdates() {
    // Get the form
    const form = document.getElementById('updateForm');
    if (!form) {
        console.error('Update form not found');
        return;
    }

    // Create FormData object from the form
    const formData = new FormData(form);
    
    // Get form values
    const tagid = document.getElementById('updateTagid').value;
    const nombre = document.getElementById('updateNombre').value; 
    const fechaNacimiento = document.getElementById('updateFechaNacimiento').value;
    const genero = document.getElementById('updateGenero').value;
    const raza = document.getElementById('updateRaza').value;
    const grupo = document.getElementById('updateGrupo').value;
    const estatus = document.getElementById('updateEstatus').value;
    const peso = document.getElementById('updatePeso').value;
    
    // Add all fields to formData
    formData.append('tagid', tagid);
    formData.append('nombre', nombre);
    formData.append('fecha_nacimiento', fechaNacimiento);
    formData.append('genero', genero);
    formData.append('raza', raza);
    formData.append('grupo', grupo);
    formData.append('estatus', estatus);
    formData.append('peso_nacimiento', peso); // Make sure to use the right field name
    
    // Add image files if selected
    const imageFile = document.getElementById('updateImageUpload').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }
    
    // Add image2 file if selected
    const image2File = document.getElementById('updateImage2Upload').files[0];
    if (image2File) {
        formData.append('image2', image2File);
    }
    
    // Add image3 file if selected
    const image3File = document.getElementById('updateImage3Upload').files[0];
    if (image3File) {
        formData.append('image3', image3File);
    }
    
    // Add video file if selected
    const videoFile = document.getElementById('updateVideoUpload').files[0];
    if (videoFile) {
        formData.append('video', videoFile);
    }

    // Show loading state
    const saveButton = document.querySelector('#updateModal .btn-outline-success');
    if (!saveButton) {
        console.error('Save button not found');
        return;
    }
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    saveButton.disabled = true;

    // Send the update request
    $.ajax({
        url: 'porcino_nacimientos_update.php',
        type: 'POST',
        data: formData,
        processData: false,  // Important for FormData
        contentType: false,  // Important for FormData
        cache: false,        // Prevent caching
        timeout: 30000,      // Increased timeout for larger files
        success: function(response) {
            try {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Los datos han sido actualizados exitosamente.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Close modal and refresh page
                        const modal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
                        if (modal) {
                            modal.hide();
                        }
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Hubo un error al actualizar los datos.'
                    });
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al procesar la respuesta del servidor.'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            
            let errorMessage = 'Hubo un error al enviar los datos';
            if (status === 'timeout') {
                errorMessage = 'La solicitud tardó demasiado tiempo. Por favor, intente de nuevo.';
            } else if (xhr.responseText) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing error response:', e);
                    // Try to extract error from HTML response
                    if (xhr.responseText.includes('<b>') && xhr.responseText.includes('</b>')) {
                        const errorMatch = xhr.responseText.match(/<b>(.*?)<\/b>/);
                        if (errorMatch && errorMatch[1]) {
                            errorMessage = 'PHP Error: ' + errorMatch[1];
                        }
                    }
                }
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        },
        complete: function() {
            // Restore button state
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    });
}

// Add form validation before submission
document.getElementById('updateModal').addEventListener('shown.bs.modal', function () {
    const form = this.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

  <!-- DataTable for porcino records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="nacimientoTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Imagen</th>
                      <th class="text-center">Acciones</th>                      
                      <th class="text-center">Nombre</th> 
                      <th class="text-center">Nació</th>                   
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Peso</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get nacimiento data directly from porcino table
                      $nacimientoQuery = "SELECT * 
                                    FROM porcino 
                                    WHERE peso_nacimiento != '0.00'
                                    ORDER BY fecha_nacimiento DESC";
                                
                      $stmt = $conn->prepare($nacimientoQuery);  
                      $stmt->execute();
                      $nacimientoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                      // If no data, display a message
                      if (empty($nacimientoData)) {
                          echo "<tr><td colspan='8' class='text-center'>No hay registros de nacimiento disponibles</td></tr>"; // Updated colspan to 8
                      } else {
                          // The foreach loop below will handle rendering the rows
                      }
                  } catch (PDOException $e) {
                      error_log("Error in nacimiento table data fetching: " . $e->getMessage());
                      echo "<tr><td colspan='8' class='text-center'>Error al cargar los datos de nacimiento: " . $e->getMessage() . "</td></tr>"; // Updated colspan to 8
                  }

                  // Ensure $compraData is iterable even if the try block failed or returned empty
                  if (!isset($nacimientoData)) {
                      $nacimientoData = []; 
                  }

                  foreach ($nacimientoData as $row) {
                      // Determine image path
                      $imagePath = './images/default_image.png'; // Default image
                      if (!empty($row['image'])) {
                          $imagePath = './' . htmlspecialchars($row['image']); // Use animal's image
                      }

                      // Render row using porcino table columns
                      echo "<tr>";
                      echo '<td class="text-center"><img src="' . $imagePath . '" alt="Animal Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>';
                      echo '<td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-warning btn-sm edit-nacimiento" 
                                    data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                    data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '"
                                    data-fecha="' . htmlspecialchars($row['fecha_nacimiento'] ?? '') . '"
                                    data-peso="' . htmlspecialchars($row['peso_nacimiento'] ?? '') . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-nacimiento" 
                                    data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                    data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>';
                      
                      echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                      echo "<td class='text-center'>" . htmlspecialchars($row['fecha_nacimiento'] ?? 'N/A') . "</td>";
                      echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                      echo "<td class='text-center'>" . htmlspecialchars($row['peso_nacimiento'] ?? '0.00') . "</td>";
                      echo "</tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH compra -->
<script>
$(document).ready(function() {
    $('#nacimientoTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[3, 'desc']],
        
        // Spanish language
        language: {
            url: './es-ES.json',
            lengthMenu: "Mostrar _MENU_ nacimientos por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ nacimientos",
            infoEmpty: "Mostrando 0 a 0 de 0 nacimientos",
            infoFiltered: "(filtrado de _MAX_ nacimientos totales)",
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
                targets: [0], // New Image column
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Assuming the image path is directly in the data or calculated in PHP
                    // The PHP code already renders the <img> tag, so we just return the cell content
                    return data; 
                }
            },
            {
                targets: [5], // Adjusted: Peso (now 5) columns
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
                targets: [3], // Adjusted: Fecha column (now 3)
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
                targets: [1], // Adjusted: Actions column (now 1)
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>

<!-- Monthly Birth Value Chart -->
<div class="container chart-container mb-4">
    <canvas id="monthlyNacimientoChart"></canvas>
</div>

<!-- JavaScript for Monthly Birth Value Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxMonthly = document.getElementById('monthlyNacimientoChart').getContext('2d');
    const monthlyLabels = <?php echo $monthlyBirthLabelsJson; ?>;
    const monthlyData = <?php echo $monthlyBirthCountsJson; ?>;

    const monthlyGradient = ctxMonthly.createLinearGradient(0, 0, 0, 400);
    monthlyGradient.addColorStop(0, 'rgba(75, 192, 192, 0.6)'); 
    monthlyGradient.addColorStop(1, 'rgba(75, 192, 192, 0.1)');

    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Nacimientos por Mes',
                data: monthlyData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: monthlyGradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#000',
                pointHoverBackgroundColor: '#000',
                pointHoverBorderColor: 'rgb(75, 192, 192)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#000', font: { size: 14 } }
                },
                title: {
                    display: true,
                    text: 'Nacimientos Mensuales',
                    color: '#000',
                    font: { size: 18, weight: 'bold' }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 4,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) { label += ': '; }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Meses (Año-Mes)', color: '#000', font: { size: 14, weight: 'bold' } },
                    ticks: { color: '#000', font: { size: 12 } },
                    grid: { color: 'rgba(38, 38, 38, 0.1)', drawBorder: true }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Cantidad de Nacimientos', color: '#000', font: { size: 14, weight: 'bold' } },
                    ticks: {
                        color: '#000',
                        font: { size: 12 },
                        callback: function(value, index, values) {
                            if (Math.floor(value) === value) {
                                return value; 
                            }
                        }
                    },
                    grid: { color: 'rgba(38, 38, 38, 0.1)', drawBorder: false }
                }
            },
            interaction: { mode: 'index', intersect: false }
        }
    });
});
</script>

<script>
$(document).ready(function() {
    // Handle edit nacimiento button clicks
    $('.edit-nacimiento').click(function() {
        // Get data from button attributes
        const id = $(this).data('id');
        const tagid = $(this).data('tagid');
        const fecha = $(this).data('fecha');
        const peso = $(this).data('peso');
        
        // Log the data for debugging
        console.log('Edit Nacimiento:', { id, tagid, fecha, peso });
        
        // Fetch complete animal data
        $.ajax({
            url: 'get_porcino_by_tagid.php',
            type: 'POST',
            dataType: 'json',
            data: { tagid: tagid },
            success: function(data) {
                if (data.success) {
                    const animal = data.animal;
                    
                    // Populate form fields with animal data
                    $('#updateTagid').val(animal.tagid);
                    $('#updateNombre').val(animal.nombre);
                    $('#updateFechaNacimiento').val(animal.fecha_nacimiento);
                    $('#updateGenero').val(animal.genero);
                    $('#updateRaza').val(animal.raza);
                    $('#updateGrupo').val(animal.grupo);
                    $('#updateEstatus').val(animal.estatus);
                    $('#updatePeso').val(animal.peso_nacimiento);
                    
                    // Set image previews if images exist
                    if (animal.image) {
                        $('#updateImagePreview').attr('src', './' + animal.image);
                    } else {
                        $('#updateImagePreview').attr('src', './images/default_image.png');
                    }
                    
                    if (animal.image2) {
                        $('#updateImage2Preview').attr('src', './' + animal.image2);
                    } else {
                        $('#updateImage2Preview').attr('src', './images/default_image.png');
                    }
                    
                    if (animal.image3) {
                        $('#updateImage3Preview').attr('src', './' + animal.image3);
                    } else {
                        $('#updateImage3Preview').attr('src', './images/default_image.png');
                    }
                    
                    // Update video preview if video exists
                    if (animal.video) {
                        const videoPreview = document.getElementById('updateVideoPreview');
                        const source = videoPreview.querySelector('source');
                        source.src = './' + animal.video;
                        videoPreview.load();
                    } else {
                        const videoPreview = document.getElementById('updateVideoPreview');
                        const source = videoPreview.querySelector('source');
                        source.src = '';
                        videoPreview.load();
                    }
                    
                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('updateModal'));
                    modal.show();
                    
                    // Initialize carousel when modal is shown
                    document.getElementById('updateModal').addEventListener('shown.bs.modal', function() {
                        new bootstrap.Carousel(document.getElementById('updateImagePreviewCarousel'), {
                            interval: 5200
                        });
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo obtener la información del animal.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos del animal.'
                });
            }
        });
    });
});
</script>

