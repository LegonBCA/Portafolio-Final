<?php
// ===================================================================
// ARCHIVO: crud/edit.php
// PROPÓSITO: Formulario para editar proyecto existente
// ===================================================================

// Incluir configuración y autenticación
require_once dirname(__DIR__) . '/includes/config.php';     // Configuración de DB y constantes
require_once dirname(__DIR__) . '/includes/auth.php';       // Sistema de autenticación

// Requerir autenticación
// Solo usuarios autenticados pueden editar proyectos
requireAuth();

// Variables para manejar mensajes de estado
$message = '';
$message_type = '';

// Obtener ID del proyecto
// Verificar que se recibió un ID válido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Si no hay ID o no es numérico, redirigir al listado
    header("Location: index.php");
    exit();
}

// Convertir a entero para seguridad
$id = (int)$_GET['id'];

// Obtener datos del proyecto usando prepared statement
// Usar prepared statement para prevenir inyección SQL
$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar que el proyecto existe
if ($result->num_rows === 0) {
    // El proyecto no existe, redirigir al listado
    header("Location: index.php");
    exit();
}

// Obtener los datos del proyecto
$proyecto = $result->fetch_assoc();

// Procesar el formulario cuando se envía
// Solo procesar cuando se reciben datos POST (formulario enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar datos del formulario
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $url_github = trim($_POST['url_github']);
    $url_produccion = trim($_POST['url_produccion']);
    
    // Validar campos requeridos
    if (empty($titulo) || empty($descripcion)) {
        $message = "El título y la descripción son obligatorios.";
        $message_type = "danger";
    } else {
        // Procesar imagen si se subió una nueva
        $imagen = $proyecto['imagen']; // Mantener imagen actual por defecto
        
        // Verificar si se subió una nueva imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Validar tipos de archivo permitidos
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['imagen']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                // Generar nombre único para evitar conflictos
                $nueva_imagen = time() . '_' . $_FILES['imagen']['name'];
                $upload_path = '../uploads/' . $nueva_imagen;
                
                // Intentar mover el archivo subido
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_path)) {
                    // Eliminar imagen anterior si existe
                    // Esto previene la acumulación de archivos huérfanos
                    if (!empty($imagen) && file_exists('../uploads/' . $imagen)) {
                        unlink('../uploads/' . $imagen);
                    }
                    // Usar la nueva imagen
                    $imagen = $nueva_imagen;
                } else {
                    $message = "Error al cargar la nueva imagen.";
                    $message_type = "danger";
                }
            } else {
                $message = "Tipo de archivo no permitido. Solo se permiten JPG, PNG, GIF y WebP.";
                $message_type = "danger";
            }
        }
        
        // Si no hay errores, actualizar en la base de datos
        if (empty($message)) {
            // Usar prepared statement para seguridad
            $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $titulo, $descripcion, $url_github, $url_produccion, $imagen, $id);
            
            if ($stmt->execute()) {
                $message = "Proyecto actualizado exitosamente.";
                $message_type = "success";
                
                // Actualizar datos del proyecto para mostrar los nuevos valores
                // Esto permite que el formulario muestre los datos actualizados inmediatamente
                $proyecto['titulo'] = $titulo;
                $proyecto['descripcion'] = $descripcion;
                $proyecto['url_github'] = $url_github;
                $proyecto['url_produccion'] = $url_produccion;
                $proyecto['imagen'] = $imagen;
            } else {
                $message = "Error al actualizar el proyecto.";
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
    <title>Editar Proyecto - <?= APP_NAME ?></title>
    
    <!-- Bootstrap CSS 5.3.3 -->
    <!-- Framework CSS para diseño responsivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <!-- Librería de iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <!-- Fuente personalizada para mejor tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Navbar -->
    <!-- Barra de navegación del panel de administración -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo/marca que lleva al portafolio público -->
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-code"></i>
                <?= APP_NAME ?>
            </a>
            
            <!-- Botones de navegación -->
            <div class="d-flex gap-3">
                <!-- Botón para volver al panel principal -->
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
                
                <!-- Botón para cerrar sesión -->
                <a href="../logout.php" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <!-- Contenido principal de la página -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Columna centrada para el formulario -->
            <div class="col-md-8">
                <div class="card">
                    <!-- Encabezado de la tarjeta -->
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit"></i>
                            Editar Proyecto
                        </h3>
                    </div>
                    
                    <!-- Cuerpo de la tarjeta con el formulario -->
                    <div class="card-body">
                        <!-- Mostrar mensaje de estado si existe -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show" role="alert">
                                <!-- Escapar HTML para prevenir XSS -->
                                <?= htmlspecialchars($message) ?>
                                <!-- Botón para cerrar la alerta -->
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Formulario de edición -->
                        <!-- enctype="multipart/form-data" necesario para subir archivos -->
                        <form method="POST" enctype="multipart/form-data">
                            <!-- Campo título (obligatorio) -->
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título del Proyecto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="titulo" name="titulo" 
                                       value="<?= htmlspecialchars($proyecto['titulo']) ?>" required>
                            </div>

                            <!-- Campo descripción (obligatorio) -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
                            </div>

                            <!-- Campo URL de GitHub (opcional) -->
                            <div class="mb-3">
                                <label for="url_github" class="form-label">URL de GitHub</label>
                                <input type="url" class="form-control" id="url_github" name="url_github" 
                                       value="<?= htmlspecialchars($proyecto['url_github']) ?>" 
                                       placeholder="https://github.com/usuario/proyecto">
                            </div>

                            <!-- Campo URL de producción (opcional) -->
                            <div class="mb-3">
                                <label for="url_produccion" class="form-label">URL de Producción</label>
                                <input type="url" class="form-control" id="url_produccion" name="url_produccion" 
                                       value="<?= htmlspecialchars($proyecto['url_produccion']) ?>" 
                                       placeholder="https://mi-proyecto.com">
                            </div>

                            <!-- Campo imagen (opcional) -->
                            <div class="mb-4">
                                <label for="imagen" class="form-label">Imagen del Proyecto</label>
                                
                                <!-- Mostrar imagen actual si existe -->
                                <?php if (!empty($proyecto['imagen'])): ?>
                                    <div class="mb-3">
                                        <img src="../uploads/<?= htmlspecialchars($proyecto['imagen']) ?>" 
                                             alt="Imagen actual" class="img-thumbnail" style="max-width: 200px;">
                                        <div class="form-text">Imagen actual</div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Campo para subir nueva imagen -->
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                                <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WebP. Tamaño máximo: 5MB. Deja vacío para mantener la imagen actual.</div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex gap-3">
                                <!-- Botón para guardar cambios -->
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Actualizar Proyecto
                                </button>
                                
                                <!-- Botón para cancelar y volver -->
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- JavaScript para componentes interactivos de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 