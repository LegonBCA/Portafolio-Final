<?php
// ===================================================================
// ARCHIVO: api/config.php
// PROPÓSITO: Configuración específica para la API REST
// ===================================================================

// Incluir configuración principal
// Carga todas las configuraciones base del sistema (DB, constantes, etc.)
require_once dirname(__DIR__) . '/includes/config.php';

// Configurar headers para API REST solo si no estamos en línea de comandos
// php_sapi_name() !== 'cli' evita configurar headers cuando se ejecuta desde terminal
if (php_sapi_name() !== 'cli') {
    // Content-Type: Especifica que todas las respuestas serán en formato JSON
    header('Content-Type: application/json');
    
    // CORS (Cross-Origin Resource Sharing) Headers
    // Access-Control-Allow-Origin: Permite peticiones desde cualquier dominio (*)
    header('Access-Control-Allow-Origin: *');
    // Access-Control-Allow-Methods: Métodos HTTP permitidos para la API
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // Access-Control-Allow-Headers: Headers permitidos en las peticiones
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}

// Manejar preflight requests
// Los navegadores envían una petición OPTIONS antes de peticiones POST/PUT/DELETE
// Esto es parte del protocolo CORS para verificar permisos
if (($_SERVER['REQUEST_METHOD'] ?? '') == 'OPTIONS') {
    // Responder con código 200 OK y terminar ejecución
    http_response_code(200);
    exit();
}

// Función para enviar respuestas JSON
/**
 * Función utilitaria para enviar respuestas JSON consistentes
 * 
 * @param array $data Datos a enviar en la respuesta (array que se convertirá a JSON)
 * @param int $statusCode Código de estado HTTP (200, 404, 500, etc.)
 */
function sendResponse($data, $statusCode = 200) {
    // Solo configurar código HTTP si no estamos en CLI
    if (php_sapi_name() !== 'cli') {
        http_response_code($statusCode);
    }
    // Convertir array PHP a JSON y enviarlo
    echo json_encode($data);
    // Terminar ejecución del script
    exit();
}

// Función para validar autenticación en API
/**
 * Verificar autenticación específicamente para endpoints de API
 * 
 * Esta función inicia sesión si es necesario y verifica si el usuario
 * está autenticado. Si no lo está, devuelve error JSON con código 401
 * 
 * @return bool true si está autenticado
 */
function checkAuthAPI() {
    // Iniciar sesión solo si no está ya iniciada
    // Prevenir errores por llamadas múltiples a session_start()
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verificar si existe la variable de sesión 'user'
    // Nota: Esta validación parece inconsistente con auth.php que usa 'user_id'
    if (!isset($_SESSION['user'])) {
        // Enviar respuesta de error con código 401 (No autorizado)
        sendResponse(['error' => 'No autorizado'], 401);
    }
    return true;
} 