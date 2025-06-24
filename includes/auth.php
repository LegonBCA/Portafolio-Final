<?php
// ===================================================================
// SISTEMA DE AUTENTICACIÓN
// ===================================================================

// Verificar si la sesión ya está iniciada
// Prevenir llamadas múltiples a session_start() que causarían error
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verificar si el usuario está autenticado
 * 
 * Revisa si existe la variable de sesión 'user_id' y si tiene el valor 'admin'
 * Este sistema usa autenticación simple con un solo usuario administrador
 * 
 * @return bool true si está autenticado, false si no
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin';
}

/**
 * Requerir autenticación - redirige a login si no está autenticado
 * 
 * Esta función se llama en páginas protegidas del panel de administración
 * Si el usuario no está logueado, lo redirige al formulario de login
 * Opcionalmente guarda la URL destino para redirigir después del login
 * 
 * @param string $redirectTo URL a la que redirigir después del login (opcional)
 */
function requireAuth($redirectTo = null) {
    // Verificar autenticación usando la función isAuthenticated()
    if (!isAuthenticated()) {
        // Guardar la URL de destino para redirigir después del login
        // Esto permite una mejor experiencia de usuario
        if ($redirectTo) {
            $_SESSION['redirect_after_login'] = $redirectTo;
        }
        
        // Determinar la ruta correcta al login según la ubicación del archivo
        $loginPath = '/NewPortafolio/login.php';
        
        // Si estamos en una subcarpeta, ajustar la ruta
        // Obtener el directorio actual del script que está ejecutándose
        $currentDir = dirname($_SERVER['PHP_SELF']);
        if (strpos($currentDir, '/crud') !== false) {
            // Si estamos en la carpeta crud, usar ruta relativa
            $loginPath = '../login.php';
        } elseif (strpos($currentDir, '/api') !== false) {
            // Si estamos en la carpeta api, usar ruta relativa
            $loginPath = '../login.php';
        }
        
        // Redirigir al formulario de login
        header("Location: $loginPath");
        exit();
    }
}

/**
 * Iniciar sesión de usuario
 * 
 * Valida las credenciales contra valores hardcodeados
 * En un sistema real, esto debería validar contra una base de datos
 * con contraseñas hasheadas
 * 
 * @param string $username nombre de usuario ingresado
 * @param string $password contraseña ingresada
 * @return bool true si las credenciales son correctas, false si no
 */
function login($username, $password) {
    // Credenciales hardcodeadas para el proyecto
    // En producción deberían estar en base de datos con hash
    if ($username === 'admin' && $password === '123456') {
        // Establecer variables de sesión para mantener el login
        $_SESSION['user_id'] = 'admin';      // Identificador del usuario
        $_SESSION['username'] = 'admin';      // Nombre de usuario para mostrar
        return true;
    }
    return false;
}

/**
 * Cerrar sesión
 * 
 * Elimina todas las variables de sesión y destruye la sesión
 * Esto garantiza que el usuario quede completamente deslogueado
 */
function logout() {
    session_unset();     // Eliminar todas las variables de sesión
    session_destroy();   // Destruir la sesión completamente
}

/**
 * Verificar autenticación para API
 * 
 * Similar a requireAuth() pero diseñado para endpoints de API
 * En lugar de redirigir, devuelve una respuesta JSON con error 401
 * 
 * Devuelve respuesta JSON si no está autenticado
 */
function requireAuthAPI() {
    // Verificar si el usuario está autenticado
    if (!isAuthenticated()) {
        // Establecer código de respuesta HTTP 401 (No autorizado)
        http_response_code(401);
        // Establecer header para respuesta JSON
        header('Content-Type: application/json');
        // Devolver respuesta de error en formato JSON
        echo json_encode([
            'success' => false,
            'message' => 'Autenticación requerida'
        ]);
        // Terminar ejecución del script
        exit();
    }
} 