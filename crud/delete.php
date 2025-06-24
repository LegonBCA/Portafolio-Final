<?php
// ===================================================================
// ARCHIVO: crud/delete.php
// PROPÓSITO: Eliminar proyecto del portafolio
// ===================================================================

// Incluir configuración y autenticación
require_once dirname(__DIR__) . '/includes/config.php';    // Configuración de DB y constantes
require_once dirname(__DIR__) . '/includes/auth.php';      // Sistema de autenticación

// Requerir autenticación
// Solo usuarios autenticados pueden eliminar proyectos
requireAuth();

// Verificar que se recibió un ID válido
// El ID debe venir por GET y ser un número entero
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Si no hay ID o no es numérico, redirigir al listado
    header("Location: index.php");
    exit();
}

// Convertir a entero para seguridad
$id = (int)$_GET['id'];

// Obtener información del proyecto antes de eliminarlo (para la imagen)
// Necesitamos el nombre de la imagen para borrarla del servidor después
$stmt = $conn->prepare("SELECT imagen FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar que el proyecto existe
if ($result->num_rows === 0) {
    // El proyecto no existe, redirigir al listado
    header("Location: index.php");
    exit();
}

// Obtener los datos del proyecto (especialmente el nombre de la imagen)
$proyecto = $result->fetch_assoc();

// Eliminar el proyecto de la base de datos usando prepared statement
// Los prepared statements previenen inyecciones SQL
$stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);

// Ejecutar la eliminación y verificar el resultado
if ($stmt->execute()) {
    // Si se eliminó exitosamente, también eliminar la imagen del servidor
    // Esto previene que se acumulen archivos huérfanos en el servidor
    if (!empty($proyecto['imagen'])) {
        // Construir la ruta completa al archivo de imagen
        $imagen_path = '../uploads/' . $proyecto['imagen'];
        // Verificar que el archivo existe antes de intentar eliminarlo
        if (file_exists($imagen_path)) {
            unlink($imagen_path);    // Eliminar archivo del sistema de archivos
        }
    }
    
    // Redirigir con mensaje de éxito
    // El parámetro 'deleted=1' permite mostrar un mensaje de confirmación
    header("Location: index.php?deleted=1");
} else {
    // Error al eliminar de la base de datos
    // El parámetro 'error=1' permite mostrar un mensaje de error
    header("Location: index.php?error=1");
}

// Terminar ejecución del script
exit();
?> 