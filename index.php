<?php
// ===================================================================
// ARCHIVO: index.php
// PROPÓSITO: Portafolio público profesional
// ===================================================================

// Incluir el archivo de configuración principal que contiene:
// - Conexión a la base de datos ($conn)
// - Constante APP_NAME
// - Configuración básica del sistema
require_once 'includes/config.php';

// Obtener todos los proyectos para mostrar en el portafolio
// Usar prepared statement para consulta segura a la base de datos
$stmt = $conn->prepare("SELECT * FROM proyectos ORDER BY created_at DESC");
// Ejecutar la consulta preparada
$stmt->execute();
// Obtener el resultado de la consulta para usar más adelante
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<!-- Definir idioma del documento como español -->
<html lang="es">
<head>
    <!-- Definir codificación de caracteres UTF-8 para mostrar acentos y caracteres especiales -->
    <meta charset="UTF-8">
    <!-- Configurar viewport para diseño responsivo en dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinámico de la página usando la constante APP_NAME del config.php -->
    <title><?= APP_NAME ?> - Portafolio Profesional</title>
    
    <!-- Preconnect para mejor performance -->
    <!-- Establecer conexión anticipada con Google Fonts para cargar más rápido -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Crossorigin para conexión segura a Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts - Inter -->
    <!-- Cargar la fuente Inter de Google Fonts con diferentes pesos (300-900) -->
    <!-- display=swap mejora la performance al mostrar fuente por defecto hasta que cargue Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS 5.3.3 -->
    <!-- Framework CSS para diseño responsivo, grid system y componentes preestilizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <!-- Librería de iconos vectoriales para mejorar la interfaz visual -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <!-- CSS personalizado que sobrescribe y complementa Bootstrap -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Meta tags para SEO -->
    <!-- Descripción de la página para motores de búsqueda -->
    <meta name="description" content="Portafolio profesional de <?= APP_NAME ?> - Desarrollador Full Stack especializado en soluciones web modernas">
    <!-- Palabras clave relevantes para SEO -->
    <meta name="keywords" content="desarrollador, full stack, php, javascript, mysql, bootstrap, portafolio">
    <!-- Autor del sitio web -->
    <meta name="author" content="<?= APP_NAME ?>">
    
    <!-- Open Graph para redes sociales -->
    <!-- Metadatos para cuando se comparte el sitio en Facebook, Twitter, etc. -->
    <meta property="og:title" content="<?= APP_NAME ?> - Portafolio Profesional">
    <meta property="og:description" content="Desarrollador Full Stack especializado en crear soluciones web innovadoras">
    <meta property="og:type" content="website">
    
    <!-- Favicon -->
    <!-- Icono que aparece en la pestaña del navegador usando emoji como SVG -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💼</text></svg>">
</head>
<body>
    
    <!-- Navbar Profesional -->
    <!-- Barra de navegación fija en la parte superior con Bootstrap -->
    <!-- navbar-dark: estilo oscuro, fixed-top: fija en la parte superior -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <!-- Container de Bootstrap para contenido centrado y responsivo -->
        <div class="container">
            <!-- Logo/marca de la página que enlaza a la sección home -->
            <a class="navbar-brand" href="#home">
                <!-- Icono de código con color info (azul claro) -->
                <i class="fas fa-code text-info me-2"></i>
                <!-- Nombre de la aplicación con efecto gradiente -->
                <span class="text-gradient"><?= APP_NAME ?></span>
            </a>
            
            <!-- Botón hamburguesa para menú móvil -->
            <!-- data-bs-toggle: activa el colapso de Bootstrap -->
            <!-- data-bs-target: especifica qué elemento colapsar -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <!-- Icono de tres líneas horizontales para el menú móvil -->
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Contenido colapsible del menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Lista de navegación alineada a la derecha (ms-auto) -->
                <ul class="navbar-nav ms-auto">
                    <!-- Elemento de navegación: Inicio -->
                    <li class="nav-item">
                        <!-- Enlace interno a la sección #home con icono -->
                        <a class="nav-link" href="#home">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <!-- Elemento de navegación: Acerca -->
                    <li class="nav-item">
                        <!-- Enlace interno a la sección #about -->
                        <a class="nav-link" href="#about">
                            <i class="fas fa-user me-1"></i>Acerca
                        </a>
                    </li>
                    <!-- Elemento de navegación: Proyectos -->
                    <li class="nav-item">
                        <!-- Enlace interno a la sección #projects -->
                        <a class="nav-link" href="#projects">
                            <i class="fas fa-briefcase me-1"></i>Proyectos
                        </a>
                    </li>
                    <!-- Elemento de navegación: Contacto -->
                    <li class="nav-item">
                        <!-- Enlace interno a la sección #contact -->
                        <a class="nav-link" href="#contact">
                            <i class="fas fa-envelope me-1"></i>Contacto
                        </a>
                    </li>
                    <!-- Botón especial para acceso administrativo -->
                    <li class="nav-item ms-3">
                        <!-- Enlace al sistema de login con estilo de botón -->
                        <!-- btn-outline-info: botón con borde azul claro -->
                        <!-- hover-lift: clase personalizada para efecto hover -->
                        <a href="login.php" class="btn btn-outline-info btn-sm rounded-pill px-4 hover-lift">
                            <i class="fas fa-lock me-1"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section Profesional -->
    <!-- Sección principal de presentación que ocupa toda la altura de la ventana -->
    <section id="home" class="hero-section d-flex align-items-center">
        <!-- Container principal del hero con clase personalizada -->
        <div class="container hero-content">
            <!-- Grid de Bootstrap: fila con alineación vertical centrada -->
            <!-- min-vh-100: altura mínima del 100% del viewport -->
            <div class="row align-items-center min-vh-100">
                <!-- Columna izquierda: información personal -->
                <!-- col-lg-6: 6 columnas en pantallas grandes, texto centrado en móviles -->
                <div class="col-lg-6 text-center text-lg-start fade-in-left">
                    <!-- Badge superior con información de estudiante -->
                    <div class="mb-4">
                        <span class="hero-badge">
                            <i class="fas fa-graduation-cap me-2"></i>Estudiante Universitario
                        </span>
                    </div>
                    <!-- Título principal con nombre en grande -->
                    <h1 class="hero-title text-white">
                        BENJAMIN
                        <!-- Apellido en nueva línea con color diferente -->
                        <span class="text-info d-block">CONTRERAS</span>
                    </h1>
                    <!-- Descripción personal y profesional -->
                    <p class="hero-subtitle text-white">
                        Estudiante informático con interés en seguridad en sistemas, bases de datos y programación backend. 
                        Me apasiona entender cómo funcionan los sistemas, proteger la información y 
                        desarrollar soluciones eficientes.
                    </p>
                    <!-- Contenedor de botones de acción -->
                    <!-- d-flex: flexbox, flex-column: columna en móviles, flex-sm-row: fila en pantallas pequeñas -->
                    <div class="hero-buttons d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <!-- Botón principal: Ver Proyectos -->
                        <a href="#projects" class="btn btn-info btn-lg">
                            <i class="fas fa-rocket me-2"></i>Ver Proyectos
                        </a>
                        <!-- Botón secundario: Contactar -->
                        <a href="#contact" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Contactar
                        </a>
                    </div>
                </div>
                <!-- Columna derecha: elementos visuales -->
                <div class="col-lg-6 text-center mt-5 mt-lg-0 fade-in-right">
                    <!-- Contenedor de visualización principal -->
                    <div class="hero-visual">
                        <!-- Elemento con posición relativa para badges flotantes -->
                        <div class="position-relative d-inline-block">
                            <!-- Círculos concéntricos con opacidad para efecto visual -->
                            <div class="bg-info bg-opacity-25 rounded-circle p-5">
                                <div class="bg-info bg-opacity-50 rounded-circle p-4">
                                    <!-- Icono central grande de laptop con código -->
                                    <i class="fas fa-laptop-code text-white" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            
                            <!-- Badges tecnológicos flotantes -->
                            <!-- Badge de JavaScript posicionado arriba a la izquierda -->
                            <div class="hero-tech-badge" style="top: 20%; left: -10%;">
                                <i class="fab fa-js-square text-warning me-1"></i>JavaScript
                            </div>
                            <!-- Badge de PHP posicionado a la derecha -->
                            <div class="hero-tech-badge" style="top: 50%; right: -15%;">
                                <i class="fab fa-php text-primary me-1"></i>PHP
                            </div>
                            <!-- Badge de MySQL posicionado abajo a la izquierda -->
                            <div class="hero-tech-badge" style="bottom: 20%; left: 10%;">
                                <i class="fas fa-database text-success me-1"></i>MySQL
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section Profesional -->
    <!-- Sección sobre información personal y profesional -->
    <section id="about" class="about-section py-5">
        <!-- Container con padding vertical extra -->
        <div class="container py-5">
            <div class="row">
                <!-- Columna centrada para el contenido principal -->
                <!-- col-lg-8: 8 columnas en pantallas grandes -->
                <!-- mx-auto: centrado horizontal automático -->
                <div class="col-lg-8 mx-auto text-center mb-5 fade-in-up">
                    <!-- Badge de sección -->
                    <span class="section-badge">
                        <i class="fas fa-user-tie me-2"></i>Sobre Mí
                    </span>
                    <!-- Título de la sección -->
                    <h2 class="section-title">Pasión por la Tecnología</h2>
                    <!-- Descripción detallada -->
                    <p class="section-description">
                        Estudiante universitario de Informática con gran interés en seguridad en sistemas, 
                        bases de datos y programación. Me apasiona entender cómo funcionan los sistemas, 
                        proteger la información y desarrollar soluciones eficientes. Actualmente, estoy 
                        ampliando mis conocimientos en estas áreas para especializarme en el futuro.
                    </p>
                </div>
            </div>
            
            <!-- Tarjetas de estadísticas -->
            <!-- g-4: gap de 4 unidades entre columnas -->
            <div class="row g-4 mb-5">
                <!-- Primera tarjeta: Proyectos Totales -->
                <!-- fade-in-up delay-100: animación con retardo -->
                <div class="col-md-4 fade-in-up delay-100">
                    <div class="stat-card">
                        <!-- Icono de la estadística -->
                        <div class="stat-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <!-- Número dinámico obtenido de la base de datos -->
                        <!-- $result->num_rows: cuenta el número de proyectos -->
                        <div class="stat-number"><?= $result->num_rows ?>+</div>
                        <!-- Etiqueta de la estadística -->
                        <div class="stat-label">Proyectos</div>
                        <!-- Descripción adicional -->
                        <div class="stat-description">Completados con éxito</div>
                    </div>
                </div>
                <!-- Segunda tarjeta: Años de estudio -->
                <div class="col-md-4 fade-in-up delay-200">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <!-- Número estático -->
                        <div class="stat-number">2+</div>
                        <div class="stat-label">Años</div>
                        <div class="stat-description">Estudiando Informática</div>
                    </div>
                </div>
                <!-- Tercera tarjeta: Dedicación -->
                <div class="col-md-4 fade-in-up delay-300">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <!-- Porcentaje de dedicación -->
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Dedicación</div>
                        <div class="stat-description">En cada proyecto</div>
                    </div>
                </div>
            </div>
            
            <!-- Stack tecnológico -->
            <!-- Sección que muestra las tecnologías y herramientas que manejo -->
            <div class="row fade-in-up delay-400">
                <!-- Columna centrada con ancho máximo de 10 unidades -->
                <div class="col-lg-10 mx-auto">
                    <!-- Tarjeta que contiene todas las tecnologías -->
                    <div class="tech-stack-card">
                        <!-- Título de la sección de tecnologías -->
                        <h4 class="text-center mb-4 text-dark fw-bold">Stack Tecnológico</h4>
                        <!-- Grid para organizar las tecnologías en filas y columnas -->
                        <div class="row g-3">
                            <!-- Tecnología 1: PHP -->
                            <!-- col-6: 2 columnas en móviles, col-md-3: 3 columnas en pantallas medianas -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de PHP con color primario (azul) -->
                                    <i class="fab fa-php text-primary"></i>
                                    <!-- Nombre de la tecnología -->
                                    <div class="fw-semibold">PHP</div>
                                </div>
                            </div>
                            <!-- Tecnología 2: JavaScript -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de JavaScript con color warning (amarillo) -->
                                    <i class="fab fa-js-square text-warning"></i>
                                    <div class="fw-semibold">JavaScript</div>
                                </div>
                            </div>
                            <!-- Tecnología 3: MySQL -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de base de datos con color success (verde) -->
                                    <i class="fas fa-database text-success"></i>
                                    <div class="fw-semibold">MySQL</div>
                                </div>
                            </div>
                            <!-- Tecnología 4: Bootstrap -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de Bootstrap con color info (azul claro) -->
                                    <i class="fab fa-bootstrap text-info"></i>
                                    <div class="fw-semibold">Bootstrap</div>
                                </div>
                            </div>
                            <!-- Tecnología 5: HTML5 -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de HTML5 con color danger (rojo) -->
                                    <i class="fab fa-html5 text-danger"></i>
                                    <div class="fw-semibold">HTML5</div>
                                </div>
                            </div>
                            <!-- Tecnología 6: CSS3 -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de CSS3 con color primario (azul) -->
                                    <i class="fab fa-css3-alt text-primary"></i>
                                    <div class="fw-semibold">CSS3</div>
                                </div>
                            </div>
                            <!-- Tecnología 7: REST API -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de servidor para representar APIs -->
                                    <i class="fas fa-server text-secondary"></i>
                                    <div class="fw-semibold">REST API</div>
                                </div>
                            </div>
                            <!-- Tecnología 8: Git -->
                            <div class="col-6 col-md-3">
                                <div class="tech-item">
                                    <!-- Icono de Git con color danger (rojo) -->
                                    <i class="fab fa-git-alt text-danger"></i>
                                    <div class="fw-semibold">Git</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section Profesional -->
    <!-- Sección principal que muestra todos los proyectos del portafolio -->
    <section id="projects" class="projects-section py-5">
        <div class="container py-5">
            <!-- Encabezado de la sección de proyectos -->
            <div class="text-center mb-5 fade-in-up">
                <!-- Badge indicativo de la sección -->
                <span class="section-badge bg-info text-dark">
                    <i class="fas fa-briefcase me-2"></i>Portfolio
                </span>
                <!-- Título principal de la sección -->
                <h2 class="section-title">Proyectos Destacados</h2>
                <!-- Descripción de lo que encontrarán en esta sección -->
                <p class="section-description">
                        Explora una selección de mis proyectos académicos y personales que demuestran mi 
                        aprendizaje en programación, bases de datos y seguridad informática.
                    </p>
            </div>

            <!-- Condicional PHP: si hay proyectos en la base de datos -->
            <?php if($result->num_rows > 0): ?>
                <!-- Grid container para las tarjetas de proyectos -->
                <div class="row g-4">
                    <?php 
                    // Variable para controlar el delay de animación
                    $delay = 100;
                    // Bucle que recorre cada proyecto de la base de datos
                    while($row = $result->fetch_assoc()): 
                    ?>
                        <!-- Columna individual para cada proyecto -->
                        <!-- col-lg-4: 3 proyectos por fila en pantallas grandes -->
                        <!-- col-md-6: 2 proyectos por fila en pantallas medianas -->
                        <div class="col-lg-4 col-md-6 fade-in-up delay-<?= $delay ?>">
                            <!-- Tarjeta del proyecto -->
                            <div class="project-card">
                                <!-- Container de la imagen del proyecto -->
                                <div class="project-image-container">
                                    <!-- Imagen del proyecto obtenida de la base de datos -->
                                    <!-- htmlspecialchars() previene ataques XSS -->
                                    <!-- loading="lazy" mejora el rendimiento cargando imágenes solo cuando son visibles -->
                                    <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" 
                                         alt="<?= htmlspecialchars($row['titulo']) ?>"
                                         loading="lazy">
                                    
                                    <!-- Overlay que aparece al hacer hover sobre la imagen -->
                                    <div class="project-overlay">
                                        <div class="project-overlay-content">
                                            <!-- Icono de ojo para indicar "ver más" -->
                                            <i class="fas fa-eye"></i>
                                            <div class="fw-semibold">Ver Detalles</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Badge que indica que el proyecto es destacado -->
                                    <div class="project-badge">
                                        <i class="fas fa-star me-1"></i>Destacado
                                    </div>
                                </div>
                                
                                <!-- Cuerpo de la tarjeta con información del proyecto -->
                                <div class="project-card-body">
                                    <!-- Título del proyecto desde la base de datos -->
                                    <h5 class="project-title">
                                        <?= htmlspecialchars($row['titulo']) ?>
                                    </h5>
                                    <!-- Descripción del proyecto desde la base de datos -->
                                    <p class="project-description">
                                        <?= htmlspecialchars($row['descripcion']) ?>
                                    </p>
                                    
                                    <!-- Container para los botones de acción -->
                                    <div class="project-buttons">
                                        <!-- Botón de GitHub (solo se muestra si hay URL) -->
                                        <?php if(!empty($row['url_github'])): ?>
                                            <!-- target="_blank": abre en nueva pestaña -->
                                            <!-- rel="noopener noreferrer": seguridad para enlaces externos -->
                                            <a href="<?= htmlspecialchars($row['url_github']) ?>" 
                                               class="btn btn-outline-dark btn-sm" 
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fab fa-github me-1"></i>Código
                                            </a>
                                        <?php endif; ?>
                                        
                                        <!-- Botón de Demo/Producción (solo se muestra si hay URL) -->
                                        <?php if(!empty($row['url_produccion'])): ?>
                                            <a href="<?= htmlspecialchars($row['url_produccion']) ?>" 
                                               class="btn btn-primary btn-sm" 
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt me-1"></i>Demo
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                    // Incrementar delay para la próxima animación
                    $delay += 100;
                    // Resetear delay cuando llegue a 500 para evitar delays muy largos
                    if($delay > 500) $delay = 100;
                    // Finalizar el bucle while
                    endwhile; 
                    ?>
                </div>
            <!-- Si NO hay proyectos en la base de datos -->
            <?php else: ?>
                <!-- Estado vacío con mensaje motivacional -->
                <div class="empty-projects fade-in-up">
                    <!-- Icono de carpeta abierta -->
                    <i class="fas fa-folder-open"></i>
                    <!-- Mensaje de estado vacío -->
                    <h4>Próximamente...</h4>
                    <p class="fs-5">Estoy trabajando en proyectos increíbles que pronto estarán disponibles aquí.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Section Profesional -->
    <!-- Sección de contacto para que los visitantes puedan comunicarse -->
    <section id="contact" class="contact-section py-5 text-white">
        <div class="container py-5">
            <div class="row">
                <!-- Columna centrada para el contenido de contacto -->
                <div class="col-lg-8 mx-auto text-center fade-in-up">
                    <!-- Badge de la sección contacto -->
                    <span class="section-badge bg-info text-dark">
                        <i class="fas fa-paper-plane me-2"></i>Contacto
                    </span>
                    <!-- Título llamativo para invitar a la colaboración -->
                    <h2 class="section-title text-white">¿Listo para Colaborar?</h2>
                    <!-- Descripción que invita al contacto profesional -->
                    <p class="section-description text-white opacity-90">
                        Siempre estoy interesado en nuevos proyectos desafiantes y oportunidades de colaboración. 
                        ¡Hablemos sobre tu próxima gran idea y hagámosla realidad juntos!
                    </p>
                    
                    <!-- Grid con las tarjetas de información de contacto -->
                    <div class="row g-4 mb-5">
                        <!-- Tarjeta 1: Email -->
                        <div class="col-md-4 fade-in-up delay-100">
                            <div class="contact-card">
                                <!-- Icono de email -->
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <!-- Título del método de contacto -->
                                <h5 class="contact-title">Email</h5>
                                <!-- Información de contacto (email actualizado) -->
                                <p class="contact-info">bcontreras2024@alu.uct.cl</p>
                            </div>
                        </div>
                        <!-- Tarjeta 2: Teléfono -->
                        <div class="col-md-4 fade-in-up delay-200">
                            <div class="contact-card">
                                <!-- Icono de teléfono -->
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5 class="contact-title">Teléfono</h5>
                                <!-- Número de teléfono actualizado -->
                                <p class="contact-info">+56 9 73886419</p>
                            </div>
                        </div>
                        <!-- Tarjeta 3: Ubicación -->
                        <div class="col-md-4 fade-in-up delay-300">
                            <div class="contact-card">
                                <!-- Icono de ubicación -->
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5 class="contact-title">Ubicación</h5>
                                <!-- Ubicación actualizada -->
                                <p class="contact-info">Temuco, Chile</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de acción para contacto directo -->
                    <!-- flex-column en móviles, flex-sm-row en pantallas pequeñas -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 fade-in-up delay-400">
                        <!-- Botón principal: enviar email -->
                        <!-- mailto: abre el cliente de email del usuario -->
                        <a href="mailto:bcontreras2024@alu.uct.cl" class="btn btn-info btn-lg">
                            <i class="fas fa-envelope me-2"></i>Enviar Email
                        </a>
                        <!-- Botón secundario: llamar por teléfono -->
                        <!-- tel: abre el marcador telefónico en dispositivos móviles -->
                        <a href="tel:+56 9 73886419" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-phone me-2"></i>Llamar Ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Profesional -->
    <!-- Pie de página con información adicional y enlaces -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <!-- Columna principal del footer: marca y redes sociales -->
                <div class="col-lg-6 mb-4 mb-lg-0 fade-in-up">
                    <!-- Marca/logo del footer -->
                    <div class="footer-brand">
                        <!-- Icono de código igual que en el navbar -->
                        <i class="fas fa-code text-info"></i>
                        <!-- Nombre de la aplicación desde config.php -->
                        <?= APP_NAME ?>
                    </div>
                    <!-- Descripción profesional en el footer -->
                    <p class="footer-description">
                        Estudiante informático con interés en seguridad en sistemas, bases de datos y programación backend.
                        Me apasiona entender cómo funcionan los sistemas, proteger la información y desarrollar soluciones eficientes.
                    </p>
                    <!-- Enlaces a redes sociales -->
                    <div class="social-links">
                        <!-- Enlace a GitHub (placeholder) -->
                        <!-- aria-label: para accesibilidad de lectores de pantalla -->
                        <a href="#" class="social-link" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <!-- Enlace a LinkedIn (placeholder) -->
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <!-- Enlace a Twitter (placeholder) -->
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <!-- Enlace a Instagram (placeholder) -->
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <!-- Segunda columna: Enlaces rápidos de navegación -->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0 fade-in-up delay-100">
                    <!-- Título de la sección -->
                    <h6 class="footer-section-title">Enlaces Rápidos</h6>
                    <!-- Lista sin estilo por defecto -->
                    <ul class="list-unstyled">
                        <!-- Enlace a sección Inicio -->
                        <li>
                            <a href="#home" class="footer-link">
                                <!-- Icono de flecha derecha como bullet point -->
                                <i class="fas fa-chevron-right text-info"></i>Inicio
                            </a>
                        </li>
                        <!-- Enlace a sección Acerca -->
                        <li>
                            <a href="#about" class="footer-link">
                                <i class="fas fa-chevron-right text-info"></i>Acerca
                            </a>
                        </li>
                        <!-- Enlace a sección Proyectos -->
                        <li>
                            <a href="#projects" class="footer-link">
                                <i class="fas fa-chevron-right text-info"></i>Proyectos
                            </a>
                        </li>
                        <!-- Enlace a sección Contacto -->
                        <li>
                            <a href="#contact" class="footer-link">
                                <i class="fas fa-chevron-right text-info"></i>Contacto
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Tercera columna: Lista de servicios/habilidades -->
                <div class="col-lg-3 col-md-6 fade-in-up delay-200">
                    <h6 class="footer-section-title">Servicios</h6>
                    <ul class="list-unstyled">
                        <!-- Servicio 1: Desarrollo Web -->
                        <li>
                            <span class="footer-service">
                                <!-- Check mark verde para indicar disponibilidad -->
                                <i class="fas fa-check text-success"></i>Desarrollo Web
                            </span>
                        </li>
                        <!-- Servicio 2: APIs REST -->
                        <li>
                            <span class="footer-service">
                                <i class="fas fa-check text-success"></i>APIs REST
                            </span>
                        </li>
                        <!-- Servicio 3: Bases de Datos -->
                        <li>
                            <span class="footer-service">
                                <i class="fas fa-check text-success"></i>Bases de Datos
                            </span>
                        </li>
                        <!-- Servicio 4: Consultoría -->
                        <li>
                            <span class="footer-service">
                                <i class="fas fa-check text-success"></i>Consultoría
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Sección inferior del footer -->
            <div class="footer-bottom">
                <!-- Fila con información de copyright -->
                <div class="row align-items-center fade-in-up delay-300">
                    <!-- Columna izquierda: copyright -->
                    <div class="col-md-6">
                        <p class="footer-copyright mb-0">
                            <!-- &copy; genera el símbolo © -->
                            <!-- date('Y') obtiene el año actual dinámicamente -->
                            &copy; <?= date('Y') ?> <?= APP_NAME ?>. Todos los derechos reservados.
                        </p>
                    </div>
                    <!-- Columna derecha: información adicional (vacía en este caso) -->
                    <div class="col-md-6 text-md-end">
                        <p class="footer-copyright mb-0">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <!-- JavaScript de Bootstrap que incluye todos los componentes interactivos -->
    <!-- .bundle incluye Popper.js para tooltips, dropdowns, etc. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth scrolling mejorado -->
    <!-- JavaScript personalizado para mejorar la experiencia de usuario -->
    <script>
        // Smooth scrolling para navegación
        // Buscar todos los enlaces que apuntan a anclas internas (href que empiece con #)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            // Agregar evento click a cada enlace
            anchor.addEventListener('click', function (e) {
                // Prevenir el comportamiento por defecto del enlace
                e.preventDefault();
                // Buscar el elemento objetivo usando el href del enlace
                const target = document.querySelector(this.getAttribute('href'));
                // Si existe el elemento objetivo
                if (target) {
                    // Calcular la posición con offset para el navbar fijo (80px)
                    const offsetTop = target.offsetTop - 80;
                    // Hacer scroll suave a la posición calculada
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'  // Animación suave
                    });
                }
            });
        });

        // Efecto navbar al hacer scroll
        // Agregar evento al scroll de la ventana
        window.addEventListener('scroll', function() {
            // Obtener referencia al navbar
            const navbar = document.querySelector('.navbar');
            // Si el usuario ha hecho scroll más de 50px
            if (window.scrollY > 50) {
                // Hacer el navbar más opaco y agregar sombra
                navbar.style.background = 'rgba(0, 0, 0, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.3)';
            } else {
                // Restaurar el navbar transparente sin sombra
                navbar.style.background = 'rgba(0, 0, 0, 0.5)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>