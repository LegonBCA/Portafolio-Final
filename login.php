<?php
// ===================================================================
// ARCHIVO: login.php
// PROPÓSITO: Sistema de autenticación de usuarios
// ===================================================================

// Incluir configuración y autenticación
require_once 'includes/config.php';      // Archivo de configuración principal (conexión DB, constantes, etc.)
require_once 'includes/auth.php';        // Funciones de autenticación y manejo de sesiones

// Variable para almacenar mensajes de error
// Se mostrará en el formulario si las credenciales son incorrectas
$error_message = '';

// Verificar si ya está autenticado
// Si el usuario ya tiene una sesión activa, redirigir al panel de administración
// Evita que usuarios ya logueados vean la página de login
if (isAuthenticated()) {
    header("Location: crud/index.php");
    exit();
}

// Verificar si el formulario fue enviado via POST
// Procesar únicamente cuando se envían datos del formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener datos del formulario
    // trim() elimina espacios en blanco al inicio y final
    // Previene errores por espacios accidentales
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Intentar login usando la función de auth.php
    // La función login() verifica las credenciales contra valores hardcodeados
    if (login($username, $password)) {
        
        // Verificar si hay una URL de redirección guardada
        // Esto permite redirigir al usuario a la página que quería acceder antes del login
        // Mejora la experiencia de usuario
        $redirect_url = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'crud/index.php';
        unset($_SESSION['redirect_after_login']);    // Limpiar la variable de sesión
        
        // Redirigir al dashboard o a la URL solicitada
        header("Location: $redirect_url");
        exit();
        
    } else {
        
        // Autenticación fallida
        // Establecer mensaje de error para mostrar en el formulario
        $error_message = "Credenciales incorrectas. Por favor intenta de nuevo.";
        
    }
}
?>
<!DOCTYPE html>
<!-- Definir idioma del documento como español -->
<html lang="es">
<head>
    <!-- Codificación de caracteres UTF-8 para acentos y caracteres especiales -->
    <meta charset="UTF-8">
    <!-- Viewport para diseño responsivo en dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinámico usando la constante APP_NAME del archivo config.php -->
    <title>Iniciar Sesión - <?= APP_NAME ?></title>
    
    <!-- Bootstrap CSS 5.3.3 -->
    <!-- Framework CSS para diseño responsivo y componentes modernos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <!-- Librería de iconos para mejorar la interfaz visual -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <!-- Preconexión para mejorar rendimiento -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Cargar fuente Inter con múltiples pesos -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <!-- Estilos personalizados que complementan Bootstrap -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<!-- Cuerpo con fondo gradiente, flexbox para centrar verticalmente y altura mínima de viewport -->
<body class="login-page">
    
    <!-- Background with animated particles -->
    <!-- Fondo animado con partículas flotantes para efecto visual -->
    <div class="login-background">
        <!-- Container de partículas animadas -->
        <div class="login-particles">
            <!-- Partículas individuales (6 elementos) -->
            <!-- Cada partícula tiene animación CSS diferente -->
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>
    
    <!-- Container fluid para ocupar toda la pantalla -->
    <div class="container-fluid h-100">
        <!-- Fila que divide la pantalla en dos partes -->
        <div class="row h-100">
            
            <!-- Left Side - Branding -->
            <!-- Lado izquierdo: información de marca y características -->
            <!-- col-lg-7: 7 columnas en pantallas grandes -->
            <!-- d-none d-lg-flex: oculto en móviles, visible en pantallas grandes -->
            <div class="col-lg-7 d-none d-lg-flex login-brand-section">
                <!-- Container principal del contenido de marca -->
                <div class="login-brand-content">
                    <!-- Logo y títulos principales -->
                    <div class="login-brand-logo">
                        <!-- Icono principal del logo -->
                        <div class="login-logo-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <!-- Título principal usando constante de config.php -->
                        <h1 class="login-brand-title"><?= APP_NAME ?></h1>
                        <!-- Subtítulo descriptivo -->
                        <p class="login-brand-subtitle">Panel de Administración Profesional</p>
                    </div>
                    
                    <!-- Sección de características del sistema -->
                    <div class="login-features">
                        <!-- Característica 1: Seguridad -->
                        <div class="login-feature">
                            <!-- Icono de la característica -->
                            <div class="login-feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <!-- Contenido descriptivo -->
                            <div class="login-feature-content">
                                <h4>Seguridad Avanzada</h4>
                                <p>Sistema de autenticación robusto y protección de datos</p>
                            </div>
                        </div>
                        
                        <!-- Característica 2: Dashboard -->
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div class="login-feature-content">
                                <h4>Dashboard Intuitivo</h4>
                                <p>Interfaz moderna y fácil de usar para gestionar tu contenido</p>
                            </div>
                        </div>
                        
                        <!-- Característica 3: Responsividad -->
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="login-feature-content">
                                <h4>Totalmente Responsive</h4>
                                <p>Accede desde cualquier dispositivo, en cualquier momento</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer de la sección de marca -->
                    <div class="login-brand-footer">
                        <p>Desarrollado por <strong>Benjamin Contreras</strong></p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <!-- Lado derecho: formulario de login -->
            <!-- col-lg-5: 5 columnas en pantallas grandes -->
            <!-- Centrado vertical y horizontal -->
            <div class="col-lg-5 d-flex align-items-center justify-content-center login-form-section">
                <!-- Container principal del formulario -->
                <div class="login-form-container">
                    
                    <!-- Mobile Brand (visible only on mobile) -->
                    <!-- Marca/logo visible solo en dispositivos móviles -->
                    <!-- d-lg-none: oculto en pantallas grandes -->
                    <div class="login-mobile-brand d-lg-none">
                        <!-- Logo para móviles -->
                        <div class="login-logo-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <!-- Título para móviles -->
                        <h2><?= APP_NAME ?></h2>
                        <!-- Subtítulo para móviles -->
                        <p>Panel de Administración</p>
                    </div>
                    
                    <!-- Login Card -->
                    <!-- Tarjeta principal que contiene el formulario -->
                    <div class="login-card">
                        <!-- Encabezado de la tarjeta -->
                        <div class="login-card-header">
                            <!-- Título de bienvenida -->
                            <h3>Bienvenido de Vuelta</h3>
                            <!-- Instrucción para el usuario -->
                            <p>Ingresa tus credenciales para acceder al panel</p>
                        </div>
                        
                        <!-- Error Message -->
                        <!-- Mensaje de error que se muestra solo si hay errores -->
                        <?php if(!empty($error_message)): ?>
                            <!-- Container del mensaje de error -->
                            <div class="login-error-alert">
                                <!-- Icono de advertencia -->
                                <div class="login-error-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <!-- Contenido del error -->
                                <div class="login-error-content">
                                    <strong>Error de Autenticación</strong>
                                    <!-- htmlspecialchars() previene ataques XSS -->
                                    <span><?= htmlspecialchars($error_message) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Login Form -->
                        <!-- Formulario principal de login -->
                        <!-- method="post": enviar datos via POST por seguridad -->
                        <!-- needs-validation: clase de Bootstrap para validación -->
                        <!-- novalidate: desactivar validación HTML5 nativa para usar la personalizada -->
                        <form method="post" class="login-form needs-validation" novalidate>
                            
                            <!-- Username Field -->
                            <!-- Campo de nombre de usuario -->
                            <div class="login-form-group">
                                <!-- Etiqueta del campo con icono -->
                                <label for="username" class="login-form-label">
                                    <i class="fas fa-user"></i>
                                    Nombre de Usuario
                                </label>
                                <!-- Campo de entrada de texto -->
                                <!-- required: campo obligatorio -->
                                <input type="text" 
                                       class="login-form-input" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Ingresa tu usuario"
                                       required>
                                <!-- Mensaje de validación -->
                                <div class="login-form-feedback">
                                    Por favor ingresa tu nombre de usuario.
                                </div>
                            </div>
                            
                            <!-- Password Field -->
                            <!-- Campo de contraseña -->
                            <div class="login-form-group">
                                <label for="password" class="login-form-label">
                                    <i class="fas fa-lock"></i>
                                    Contraseña
                                </label>
                                <div class="login-password-container">
                                    <input type="password" 
                                           class="login-form-input" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Ingresa tu contraseña"
                                           required>
                                    <button type="button" class="login-password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                <div class="login-form-feedback">
                                    Por favor ingresa tu contraseña.
                                </div>
                            </div>
                            
                            <!-- Remember Me -->
                            <div class="login-form-check">
                                <input type="checkbox" id="remember" class="login-checkbox" checked>
                                <label for="remember" class="login-checkbox-label">
                                    <span class="login-checkmark">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    Recordar mi sesión
                                </label>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" class="login-submit-btn">
                                <span class="login-btn-text">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Iniciar Sesión
                                </span>
                                <div class="login-btn-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Verificando...
                                </div>
                            </button>
                            
                            <!-- Back to Portfolio -->
                            <a href="index.php" class="login-back-btn">
                                <i class="fas fa-arrow-left"></i>
                                Volver al Portafolio
                            </a>
                            
                        </form>
                        

                        
                    </div>
                    
                    <!-- Footer -->
                    <div class="login-footer">
                        <p>
                            <i class="fas fa-heart text-danger"></i>
                            Desarrollado con Bootstrap 5.3.3
                        </p>
                        <small>
                            <?= APP_NAME ?> &copy; <?= date('Y') ?> - Todos los derechos reservados
                        </small>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- JavaScript para componentes interactivos de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enhanced Login JavaScript -->
    <script>
        // Form Validation
        (function() {
            'use strict';
            // Ejecutar cuando la página termine de cargar
            window.addEventListener('load', function() {
                // Obtener todos los formularios con clase 'needs-validation'
                var forms = document.getElementsByClassName('needs-validation');
                // Aplicar validación a cada formulario
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        // Si el formulario no es válido, prevenir el envío
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Show loading state
                            const submitBtn = form.querySelector('.login-submit-btn');
                            submitBtn.classList.add('loading');
                        }
                        // Agregar clase para mostrar estilos de validación
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordEye = document.getElementById('password-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordEye.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordEye.className = 'fas fa-eye';
            }
        }

        // Enhanced interactions and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate login elements on load
            const loginCard = document.querySelector('.login-card');
            const brandContent = document.querySelector('.login-brand-content');
            
            if (loginCard) {
                loginCard.style.opacity = '0';
                loginCard.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    loginCard.style.opacity = '1';
                    loginCard.style.transform = 'translateY(0)';
                }, 300);
            }
            
            if (brandContent) {
                brandContent.style.opacity = '0';
                brandContent.style.transform = 'translateX(-30px)';
                
                setTimeout(() => {
                    brandContent.style.opacity = '1';
                    brandContent.style.transform = 'translateX(0)';
                }, 500);
            }

            // Input focus effects
            const inputs = document.querySelectorAll('.login-form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
                
                // Check if input has value on load
                if (input.value) {
                    input.parentElement.classList.add('focused');
                }
            });

            // Auto-focus on username field
            const usernameField = document.getElementById('username');
            if (usernameField) {
                setTimeout(() => {
                    usernameField.focus();
                }, 800);
            }

            // Animate particles
            const particles = document.querySelectorAll('.particle');
            particles.forEach((particle, index) => {
                particle.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
</body>
</html>

