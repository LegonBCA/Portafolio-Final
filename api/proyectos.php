<?php
// ===================================================================
// ARCHIVO: api/proyectos.php
// PROPÓSITO: API REST para CRUD de proyectos
// MÉTODOS: GET, POST, PUT, DELETE
// ===================================================================

// LÍNEA 8: Incluir archivo de configuración de la API (headers, funciones sendResponse, etc.)
require_once 'config.php';
// LÍNEA 9: Incluir sistema de autenticación desde la carpeta padre usando dirname(__DIR__)
require_once dirname(__DIR__) . '/includes/auth.php';

// LÍNEA 12: Obtener el método HTTP de la petición (GET, POST, PUT, DELETE) 
// Usar ?? 'GET' como valor por defecto si no está definido $_SERVER['REQUEST_METHOD']
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
// LÍNEA 14: Obtener la URI completa de la petición (ejemplo: /api/proyectos/123)
// $_SERVER['REQUEST_URI'] contiene la ruta completa de la URL solicitada
$path = $_SERVER['REQUEST_URI'] ?? '';
// LÍNEA 16: Dividir la ruta en partes separadas por '/' y quitar espacios con trim()
// Ejemplo: "/api/proyectos/123" se convierte en array ['api', 'proyectos', '123']
$path_parts = explode('/', trim($path, '/'));

// LÍNEA 18-23: Extraer el ID del proyecto de la URL si existe y es válido
// Ejemplo: en /api/proyectos/123 el ID sería 123 (posición 3 del array)
$project_id = null;
// LÍNEA 21: Verificar si existe el índice 3 del array y si es un número
// isset() verifica que exista la posición, is_numeric() verifica que sea número
if (isset($path_parts[3]) && is_numeric($path_parts[3])) {
    // LÍNEA 22: Convertir a entero el ID del proyecto extraído de la URL
    // (int) hace casting explícito a entero para seguridad
    $project_id = (int)$path_parts[3];
}

// LÍNEA 26: Enrutador principal - determina qué función ejecutar según el método HTTP
// Switch evalúa la variable $method y ejecuta el case correspondiente
switch ($method) {
    // LÍNEA 28: Manejo de peticiones GET (obtener/leer datos)
    case 'GET':
        // LÍNEA 29-30: Comentarios explicando los dos tipos de GET posibles
        // GET /api/proyectos -> obtener todos los proyectos
        // GET /api/proyectos/123 -> obtener proyecto específico por ID
        // LÍNEA 31: Condicional para determinar si buscar uno específico o todos
        if ($project_id) {
            // LÍNEA 32: Llamar función para obtener un proyecto específico por ID
            getProject($project_id);
        } else {
            // LÍNEA 34: Si no hay ID, obtener todos los proyectos de la base de datos
            getAllProjects();
        }
        // LÍNEA 36: Terminar el case GET y salir del switch
        break;
        
    // LÍNEA 38: Manejo de peticiones POST (crear nuevos registros)
    case 'POST':
        // LÍNEA 39-40: Comentarios explicando qué hace POST y requisitos
        // POST /api/proyectos -> crear nuevo proyecto en la base de datos
        // Requiere autenticación para poder crear proyectos
        // LÍNEA 41: Verificar autenticación antes de permitir crear - llama requireAuthAPI()
        requireAuthAPI();
        // LÍNEA 42: Llamar función para crear nuevo proyecto con datos del JSON
        createProject();
        // LÍNEA 43: Terminar el case POST
        break;
        
    // LÍNEA 45: Manejo de peticiones PUT (actualizar registros existentes)
    case 'PUT':
        // LÍNEA 46-47: Comentarios explicando qué hace PUT y requisitos
        // PUT /api/proyectos/123 -> actualizar proyecto específico por ID
        // Requiere autenticación para poder actualizar proyectos
        // LÍNEA 48: Verificar autenticación antes de permitir actualizar
        requireAuthAPI();
        // LÍNEA 49-51: Validar que se proporcione ID del proyecto a actualizar
        if (!$project_id) {
            // LÍNEA 50: Enviar error 400 (Bad Request) si no se proporciona ID
            sendResponse(['error' => 'ID de proyecto requerido'], 400);
        }
        // LÍNEA 52: Llamar función para actualizar proyecto con el ID especificado
        updateProject($project_id);
        // LÍNEA 53: Terminar el case PUT
        break;
        
    // LÍNEA 55: Manejo de peticiones DELETE (eliminar registros)
    case 'DELETE':
        // LÍNEA 56-57: Comentarios explicando qué hace DELETE y requisitos
        // DELETE /api/proyectos/123 -> eliminar proyecto específico por ID
        // Requiere autenticación para poder eliminar proyectos
        // LÍNEA 58: Verificar autenticación antes de permitir eliminar
        requireAuthAPI();
        // LÍNEA 59-61: Validar que se proporcione ID del proyecto a eliminar
        if (!$project_id) {
            // LÍNEA 60: Enviar error 400 (Bad Request) si no se proporciona ID
            sendResponse(['error' => 'ID de proyecto requerido'], 400);
        }
        // LÍNEA 62: Llamar función para eliminar proyecto con el ID especificado
        deleteProject($project_id);
        // LÍNEA 63: Terminar el case DELETE
        break;
        
    // LÍNEA 65: Case por defecto para métodos HTTP no soportados (ej: PATCH, HEAD)
    default:
        // LÍNEA 66: Comentario explicando manejo de métodos HTTP no válidos
        // Método HTTP no soportado por esta API
        // LÍNEA 67: Enviar error 405 (Method Not Allowed) para métodos no implementados
        sendResponse(['error' => 'Método no permitido'], 405);
}

// LÍNEA 70-72: Separador visual y comentarios para organizar las funciones de la API
// ===================================================================
// FUNCIONES DE LA API
// ===================================================================

/**
 * LÍNEA 74-79: Documentación PHPDoc de la función getAllProjects()
 * Obtener todos los proyectos de la base de datos
 * 
 * Endpoint público - no requiere autenticación
 * Retorna un array JSON con todos los proyectos ordenados por fecha de creación
 */
function getAllProjects() {
    // LÍNEA 81: Declarar variable global para acceder a la conexión de base de datos
    // $conn viene del archivo config.php incluido al inicio
    global $conn;
    
    // LÍNEA 84: Inicio del bloque try para manejo controlado de errores
    try {
        // LÍNEA 85: Comentario explicando uso de prepared statement para seguridad
        // Consulta SQL usando prepared statement para prevenir inyección SQL
        // LÍNEA 86: Preparar consulta SQL para obtener todos los proyectos ordenados por fecha DESC (más recientes primero)
        $stmt = $conn->prepare("SELECT id, titulo, descripcion, url_github, url_produccion, imagen, created_at FROM proyectos ORDER BY created_at DESC");
        // LÍNEA 87: Ejecutar la consulta preparada (no necesita parámetros en este caso)
        $stmt->execute();
        // LÍNEA 88: Obtener el objeto resultado de la consulta ejecutada
        $result = $stmt->get_result();
        
        // LÍNEA 90: Comentario explicando conversión de resultado a array PHP
        // Convertir el resultado de MySQL en un array PHP manipulable
        // LÍNEA 91: Inicializar array vacío para almacenar todos los proyectos
        $projects = [];
        // LÍNEA 92-94: Loop while para recorrer cada fila del resultado de la consulta
        while ($row = $result->fetch_assoc()) {
            // LÍNEA 93: Agregar cada fila (proyecto) al array $projects
            // fetch_assoc() retorna array asociativo con nombres de columnas como claves
            $projects[] = $row;
        }
        
        // LÍNEA 96: Comentario explicando envío de respuesta exitosa
        // Enviar respuesta JSON exitosa con todos los datos de proyectos
        // LÍNEA 97: Usar función sendResponse() para enviar JSON con success=true y array de datos
        sendResponse(['success' => true, 'data' => $projects]);
    } catch (Exception $e) {
        // LÍNEA 99: Comentario explicando manejo de errores sin exponer información sensible
        // En caso de error SQL u otro, enviar respuesta de error genérica
        // LÍNEA 100: Enviar error 500 (Internal Server Error) sin mostrar detalles del error real
        sendResponse(['error' => 'Error al obtener proyectos'], 500);
    }
}

/**
 * LÍNEA 104-110: Documentación PHPDoc de la función getProject()
 * Obtener un proyecto específico por su ID
 * 
 * Endpoint público - no requiere autenticación
 * 
 * @param int $id ID del proyecto a obtener de la base de datos
 */
function getProject($id) {
    // LÍNEA 112: Declarar variable global para acceder a la conexión de BD
    global $conn;
    
    // LÍNEA 114: Inicio del bloque try para manejo controlado de errores
    try {
        // LÍNEA 115: Comentario explicando prepared statement para seguridad
        // Usar prepared statement para prevenir inyección SQL en la consulta WHERE
        // LÍNEA 116: Preparar consulta SQL con placeholder ? para el parámetro ID
        $stmt = $conn->prepare("SELECT id, titulo, descripcion, url_github, url_produccion, imagen, created_at FROM proyectos WHERE id = ?");
        // LÍNEA 117: Bind del parámetro ID como entero ("i" = integer type)
        $stmt->bind_param("i", $id);
        // LÍNEA 118: Ejecutar la consulta con el parámetro ID vinculado
        $stmt->execute();
        // LÍNEA 119: Obtener el resultado de la consulta ejecutada
        $result = $stmt->get_result();
        
        // LÍNEA 121: Comentario explicando verificación de existencia del proyecto
        // Verificar si el proyecto existe en la base de datos
        // LÍNEA 122-124: Si num_rows es 0, significa que no se encontró el proyecto
        if ($result->num_rows === 0) {
            // LÍNEA 123: Enviar error 404 (Not Found) si el proyecto no existe
            sendResponse(['error' => 'Proyecto no encontrado'], 404);
        }
        
        // LÍNEA 126: Comentario explicando obtención y envío de datos
        // Obtener los datos del proyecto encontrado y enviarlos como JSON
        // LÍNEA 127: Obtener la fila como array asociativo (clave=valor)
        $project = $result->fetch_assoc();
        // LÍNEA 128: Enviar respuesta exitosa con los datos del proyecto específico
        sendResponse(['success' => true, 'data' => $project]);
    } catch (Exception $e) {
        // LÍNEA 130: Comentario explicando manejo de errores del servidor
        // Error del servidor (problemas de conexión, SQL, etc.)
        // LÍNEA 131: Enviar error 500 (Internal Server Error) sin exponer detalles
        sendResponse(['error' => 'Error al obtener proyecto'], 500);
    }
}

/**
 * Crear un nuevo proyecto
 * 
 * Requiere autenticación
 * Espera datos JSON en el cuerpo de la petición
 */
function createProject() {
    global $conn;
    
    // Obtener datos JSON del cuerpo de la petición
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validar que se recibió JSON válido
    if (!$input) {
        sendResponse(['error' => 'Datos JSON inválidos'], 400);
    }
    
    // Validar campos requeridos
    if (empty($input['titulo']) || empty($input['descripcion'])) {
        sendResponse(['error' => 'Título y descripción son requeridos'], 400);
    }
    
    // Extraer datos del JSON (usar ?? null para campos opcionales)
    $titulo = $input['titulo'];
    $descripcion = $input['descripcion'];
    $url_github = $input['url_github'] ?? null;
    $url_produccion = $input['url_produccion'] ?? null;
    $imagen = $input['imagen'] ?? null;
    
    try {
        // Insertar nuevo proyecto usando prepared statement
        $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $titulo, $descripcion, $url_github, $url_produccion, $imagen);
        
        if ($stmt->execute()) {
            // Obtener el ID del proyecto recién creado
            $project_id = $conn->insert_id;
            sendResponse(['success' => true, 'message' => 'Proyecto creado exitosamente', 'id' => $project_id], 201);
        } else {
            sendResponse(['error' => 'Error al crear proyecto'], 500);
        }
    } catch (Exception $e) {
        sendResponse(['error' => 'Error al crear proyecto'], 500);
    }
}

/**
 * Actualizar un proyecto existente
 * 
 * Requiere autenticación
 * Espera datos JSON en el cuerpo de la petición
 * 
 * @param int $id ID del proyecto a actualizar
 */
function updateProject($id) {
    global $conn;
    
    // Verificar que el proyecto existe antes de intentar actualizarlo
    $check_stmt = $conn->prepare("SELECT id FROM proyectos WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows === 0) {
        sendResponse(['error' => 'Proyecto no encontrado'], 404);
    }
    
    // Obtener datos JSON del cuerpo de la petición
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validar JSON
    if (!$input) {
        sendResponse(['error' => 'Datos JSON inválidos'], 400);
    }
    
    // Extraer datos del JSON (usar ?? '' para campos de texto, ?? null para URLs)
    $titulo = $input['titulo'] ?? '';
    $descripcion = $input['descripcion'] ?? '';
    $url_github = $input['url_github'] ?? null;
    $url_produccion = $input['url_produccion'] ?? null;
    $imagen = $input['imagen'] ?? null;
    
    try {
        // Actualizar proyecto usando prepared statement
        $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ?, imagen = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $titulo, $descripcion, $url_github, $url_produccion, $imagen, $id);
        
        if ($stmt->execute()) {
            sendResponse(['success' => true, 'message' => 'Proyecto actualizado exitosamente']);
        } else {
            sendResponse(['error' => 'Error al actualizar proyecto'], 500);
        }
    } catch (Exception $e) {
        sendResponse(['error' => 'Error al actualizar proyecto'], 500);
    }
}

/**
 * Eliminar un proyecto
 * 
 * Requiere autenticación
 * También elimina la imagen asociada del servidor
 * 
 * @param int $id ID del proyecto a eliminar
 */
function deleteProject($id) {
    global $conn;
    
    // Obtener información del proyecto antes de eliminarlo (para borrar la imagen)
    $check_stmt = $conn->prepare("SELECT imagen FROM proyectos WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    // Verificar que el proyecto existe
    if ($result->num_rows === 0) {
        sendResponse(['error' => 'Proyecto no encontrado'], 404);
    }
    
    // Obtener datos del proyecto
    $project = $result->fetch_assoc();
    
    try {
        // Eliminar proyecto de la base de datos
        $stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Si se eliminó exitosamente, también eliminar la imagen del servidor
            if ($project['imagen'] && file_exists("../uploads/" . $project['imagen'])) {
                unlink("../uploads/" . $project['imagen']);
            }
            
            sendResponse(['success' => true, 'message' => 'Proyecto eliminado exitosamente']);
        } else {
            sendResponse(['error' => 'Error al eliminar proyecto'], 500);
        }
    } catch (Exception $e) {
        sendResponse(['error' => 'Error al eliminar proyecto'], 500);
    }
}
?> 