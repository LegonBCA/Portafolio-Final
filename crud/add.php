<?php
// ===================================================================
// ARCHIVO: crud/add.php
// PROPÓSITO: Formulario para agregar nuevo proyecto
// ===================================================================

// Incluir configuración y autenticación
require_once dirname(__DIR__) . '/includes/config.php';    // Configuración de DB y constantes
require_once dirname(__DIR__) . '/includes/auth.php';      // Sistema de autenticación

// Requerir autenticación
// Solo usuarios autenticados pueden agregar proyectos
requireAuth();

// Variables para manejar mensajes de estado
$message = '';
$message_type = '';

// Procesar el formulario cuando se envía
// Solo procesar cuando se reciben datos POST (formulario enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar datos del formulario
    // trim() elimina espacios en blanco al inicio y final
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $url_github = trim($_POST['url_github']);
    $url_produccion = trim($_POST['url_produccion']);
    
    // Validar campos requeridos
    if (empty($titulo) || empty($descripcion)) {
        $message = "El título y la descripción son obligatorios.";
        $message_type = "danger";
    } else {
        // Procesar imagen
        $imagen = '';
        // Verificar si se subió un archivo de imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir tipos de archivo permitidos para seguridad
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['imagen']['type'];
            
            // Validar que el tipo de archivo esté permitido
            if (in_array($file_type, $allowed_types)) {
                // Obtener extensión del archivo original
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                // Generar nombre único usando timestamp para evitar conflictos
                $imagen = time() . '_' . $_FILES['imagen']['name'];
                // Definir ruta donde se guardará el archivo
                $upload_path = '../uploads/' . $imagen;
                
                // Intentar mover el archivo desde temporal al directorio uploads
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_path)) {
                    // Imagen cargada exitosamente
                } else {
                    $message = "Error al cargar la imagen.";
                    $message_type = "danger";
                }
            } else {
                $message = "Tipo de archivo no permitido. Solo se permiten JPG, PNG, GIF y WebP.";
                $message_type = "danger";
            }
        }
        
        // Si no hay errores, insertar en la base de datos
        if (empty($message)) {
            // Usar prepared statement para prevenir inyección SQL
            $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $titulo, $descripcion, $url_github, $url_produccion, $imagen);
            
            // Ejecutar la consulta y verificar resultado
            if ($stmt->execute()) {
                $message = "¡Proyecto agregado exitosamente! 🎉";
                $message_type = "success";
                
                // Limpiar campos después del éxito
                // Esto permite agregar otro proyecto sin recargar la página
                $titulo = $descripcion = $url_github = $url_produccion = '';
            } else {
                $message = "Error al agregar el proyecto.";
                $message_type = "danger";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinámico usando constante del config -->
    <title>Agregar Proyecto - <?= APP_NAME ?></title>
    
    <!-- Bootstrap CSS 5.3.3 -->
    <!-- Framework CSS para diseño responsivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <!-- Librería de iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light">
    
    <!-- Navbar -->
    <!-- Barra de navegación del panel de administración -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid px-4">
            <!-- Logo/marca que lleva al portafolio público -->
            <a class="navbar-brand fw-bold fs-4" href="../index.php">
                <i class="fas fa-code text-warning me-2"></i>
                <span class="text-white"><?= APP_NAME ?></span>
                <span class="badge bg-warning text-dark ms-2 fs-6">Admin</span>
            </a>
            
            <!-- Botón para colapsar menú en móviles -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Botones de navegación alineados a la derecha -->
                <div class="d-flex gap-2 ms-auto">
                    <!-- Botón para volver al panel principal -->
                    <a href="index.php" class="btn btn-outline-light">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    
                    <!-- Botón para ver el sitio público -->
                    <a href="../index.php" class="btn btn-outline-light">
                        <i class="fas fa-globe me-2"></i>Ver Sitio
                    </a>
                    
                    <!-- Botón para cerrar sesión -->
                    <a href="../logout.php" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- Sección principal con título y navegación breadcrumb -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <!-- Navegación breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.php" class="text-white text-decoration-none opacity-75">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-white fw-semibold" aria-current="page">
                        <i class="fas fa-plus me-1"></i>Agregar Proyecto
                    </li>
                </ol>
            </nav>
            
            <!-- Título principal de la página -->
            <div class="text-center">
                <div class="mx-auto mb-3">
                    <i class="fas fa-plus-circle text-white fs-1"></i>
                </div>
                <h1 class="display-6 fw-bold mb-2">Agregar Nuevo Proyecto</h1>
                <p class="fs-6 mb-0 opacity-90">
                    Completa el formulario para agregar un proyecto a tu portafolio
                </p>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <!-- Sección principal con el formulario de agregar proyecto -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Columna centrada para el formulario -->
            <div class="col-lg-10 col-xl-8">
                
                <!-- Mostrar mensaje de estado si existe -->
                <?php if(!empty($message)): ?>
                    <div class="alert alert-<?= $message_type ?> alert-dismissible fade show shadow mb-4" role="alert">
                        <div class="d-flex align-items-start">
                            <?php if($message_type === 'success'): ?>
                                <!-- Icono de éxito -->
                                <i class="fas fa-check-circle me-3 fs-3 text-success"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">¡Éxito!</h5>
                                    <p class="mb-0"><?= htmlspecialchars($message) ?></p>
                                </div>
                            <?php else: ?>
                                <!-- Icono de error -->
                                <i class="fas fa-exclamation-triangle me-3 fs-3 text-danger"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Error</h5>
                                    <p class="mb-0"><?= htmlspecialchars($message) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Botón para cerrar la alerta -->
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Tarjeta principal del formulario -->
                <div class="card border-0 shadow">
                    <!-- Encabezado de la tarjeta -->
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="fw-bold mb-0">
                            <i class="fas fa-edit me-2"></i>Formulario de Proyecto
                        </h4>
                    </div>
                    
                    <!-- Cuerpo de la tarjeta con el formulario -->
                    <div class="card-body p-4">

                        <!-- Formulario principal -->
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="row g-4">
                                
                                <!-- Campo título -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" 
                                               class="form-control" 
                                               id="titulo" 
                                               name="titulo" 
                                               placeholder="Título del proyecto"
                                               value="<?= isset($titulo) ? htmlspecialchars($titulo) : '' ?>"
                                               required>
                                        <label for="titulo">
                                            <i class="fas fa-heading me-2"></i>Título del Proyecto *
                                        </label>
                                        <div class="invalid-feedback">Por favor ingresa un título para tu proyecto.</div>
                                    </div>
                                </div>

                                <!-- Campo descripción -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" 
                                                  id="descripcion" 
                                                  name="descripcion" 
                                                  placeholder="Descripción del proyecto"
                                                  style="min-height: 120px;"
                                                  required><?= isset($descripcion) ? htmlspecialchars($descripcion) : '' ?></textarea>
                                        <label for="descripcion">
                                            <i class="fas fa-align-left me-2"></i>Descripción del Proyecto *
                                        </label>
                                        <div class="invalid-feedback">Por favor describe tu proyecto.</div>
                                    </div>
                                </div>

                                <!-- Campo URL GitHub -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               class="form-control" 
                                               id="url_github" 
                                               name="url_github" 
                                               placeholder="https://github.com/usuario/proyecto"
                                               value="<?= isset($url_github) ? htmlspecialchars($url_github) : '' ?>">
                                        <label for="url_github">
                                            <i class="fab fa-github me-2"></i>GitHub (Opcional)
                                        </label>
                                        <div class="invalid-feedback">Por favor ingresa una URL válida.</div>
                                    </div>
                                </div>

                                <!-- Campo URL Producción -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               class="form-control" 
                                               id="url_produccion" 
                                               name="url_produccion" 
                                               placeholder="https://miproyecto.com"
                                               value="<?= isset($url_produccion) ? htmlspecialchars($url_produccion) : '' ?>">
                                        <label for="url_produccion">
                                            <i class="fas fa-external-link-alt me-2"></i>Demo en Vivo (Opcional)
                                        </label>
                                        <div class="invalid-feedback">Por favor ingresa una URL válida.</div>
                                    </div>
                                </div>

                                <!-- Campo imagen -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="imagen" class="form-label">
                                            <i class="fas fa-image me-2"></i>Imagen del Proyecto
                                        </label>
                                        <input type="file" 
                                               class="form-control" 
                                               id="imagen" 
                                               name="imagen" 
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WebP</div>
                                    </div>
                                </div>

                                <!-- Vista previa de imagen -->
                                <div class="col-12">
                                    <div id="imagePreview" class="d-none">
                                        <div class="card bg-light p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img id="previewImg" src="" alt="Vista previa" class="rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" id="fileName"></h6>
                                                    <small class="text-muted" id="fileSize"></small>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeImage()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="col-12">
                                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                            <i class="fas fa-undo me-2"></i>Limpiar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Agregar Proyecto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer del panel de administración -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-2 me-3">
                            <i class="fas fa-plus-square text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-white">Agregar Proyecto</h6>
                            <p class="mb-0 text-light small">
                                Mantén tu portafolio actualizado con tus últimos trabajos
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="mb-1 text-light">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Desarrollado con Bootstrap 5.3.3
                    </p>
                    <small class="text-muted">
                        <?= APP_NAME ?> &copy; <?= date('Y') ?> - Sistema de Gestión de Portafolio
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <!-- JavaScript para componentes interactivos de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enhanced Form JavaScript -->
    <script>
        // ===================================================================
        // SCRIPT: Validación y funcionalidad del formulario
        // PROPÓSITO: Manejar validación HTML5, vista previa de imágenes y UX
        // ===================================================================

        // Validación de formulario usando Bootstrap
        // Aplica validación HTML5 con estilos de Bootstrap
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Obtener todos los formularios que requieren validación
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        // Si el formulario no es válido, prevenir envío
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        // Agregar clase para mostrar estados de validación
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Función para vista previa de imagen
        // Muestra una vista previa cuando se selecciona un archivo
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');

            // Verificar si se seleccionó un archivo
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                // Cuando se carga el archivo, mostrar vista previa
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    preview.classList.remove('d-none');
                };

                // Leer el archivo como URL de datos
                reader.readAsDataURL(file);
            }
        }

        // Función para remover imagen seleccionada
        // Limpia la selección y oculta la vista previa
        function removeImage() {
            const preview = document.getElementById('imagePreview');
            const input = document.getElementById('imagen');
            
            // Ocultar vista previa y limpiar input
            preview.classList.add('d-none');
            input.value = '';
        }

        // Función para resetear formulario
        // Limpia todos los campos con confirmación del usuario
        function resetForm() {
            if (confirm('¿Estás seguro de que quieres limpiar todos los campos del formulario?')) {
                // Resetear formulario y remover imagen
                document.querySelector('form').reset();
                removeImage();
                // Quitar estados de validación
                document.querySelector('form').classList.remove('was-validated');
            }
        }

        // Función auxiliar para formatear tamaño de archivo
        // Convierte bytes a formato legible (KB, MB, etc.)
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html> 