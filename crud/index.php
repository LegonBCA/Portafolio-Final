<?php
// ===================================================================
// ARCHIVO: crud/index.php
// PROPÓSITO: Dashboard de administración de proyectos
// ===================================================================

// Incluir configuración y autenticación
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';

// Requerir autenticación
requireAuth();

// Consulta SQL para obtener todos los proyectos usando prepared statement
$stmt = $conn->prepare("SELECT * FROM proyectos ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - <?= APP_NAME ?></title>
    
    <!-- Bootstrap CSS 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-dashboard">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4" href="../index.php">
                <i class="fas fa-code text-warning me-2"></i>
                <span class="text-white"><?= APP_NAME ?></span>
                <span class="badge bg-warning text-dark ms-2 fs-6">Admin</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-warning fw-semibold">
                            <i class="fas fa-user-shield me-2"></i>
                            Panel de Control
                        </span>
                    </li>
                </ul>
                
                <div class="d-flex gap-2">
                    <a href="add.php" class="btn btn-warning text-dark fw-semibold px-4 rounded-pill">
                        <i class="fas fa-plus me-2"></i>Nuevo Proyecto
                    </a>
                    
                    <a href="../index.php" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-globe me-2"></i>Ver Sitio
                    </a>
                    
                    <a href="../logout.php" class="btn btn-outline-danger rounded-pill px-4">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Dashboard Section -->
    <section class="dashboard-hero text-white py-5">
        <div class="container">
            <div class="row align-items-center dashboard-hero-content">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-4">
                        <div class="dashboard-hero-icon rounded-circle p-4 me-4">
                            <i class="fas fa-tachometer-alt text-white fs-1"></i>
                        </div>
                        <div>
                            <h1 class="display-5 fw-bold mb-2">Dashboard Administrativo</h1>
                            <p class="fs-5 mb-0 opacity-90">
                                Gestiona tu portafolio profesional de manera eficiente y moderna
                            </p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="dashboard-badge">
                            <i class="fas fa-check me-1"></i>Sistema Activo
                        </span>
                        <span class="dashboard-badge">
                            <i class="fas fa-database me-1"></i><?= $result->num_rows ?> Proyectos
                        </span>
                        <span class="dashboard-badge">
                            <i class="fas fa-clock me-1"></i>Última actualización: <?= date('d/m/Y H:i') ?>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-4 mt-lg-0">
                    <div class="position-relative">
                        <div class="dashboard-hero-icon rounded-circle p-5 d-inline-block">
                            <i class="fas fa-laptop-code text-white" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Cards -->
    <div class="container stats-container">
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-admin border-0 h-100">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="stat-icon-admin bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-folder fs-2"></i>
                        </div>
                        <h3 class="stat-number-admin mb-2"><?= $result->num_rows ?></h3>
                        <h6 class="stat-label-admin mb-1">Proyectos Totales</h6>
                        <p class="stat-description-admin mb-0">En tu portafolio</p>
                        <div class="position-absolute top-0 end-0 m-3">
                            <i class="fas fa-arrow-up text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-admin border-0 h-100">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="stat-icon-admin bg-success bg-opacity-10 text-success">
                            <i class="fas fa-eye fs-2"></i>
                        </div>
                        <h3 class="stat-number-admin text-success mb-2">2.5k</h3>
                        <h6 class="stat-label-admin mb-1">Visualizaciones</h6>
                        <p class="stat-description-admin mb-0">Este mes</p>
                        <div class="position-absolute top-0 end-0 m-3">
                            <i class="fas fa-arrow-up text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-admin border-0 h-100">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="stat-icon-admin bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-star fs-2"></i>
                        </div>
                        <h3 class="stat-number-admin text-warning mb-2">98%</h3>
                        <h6 class="stat-label-admin mb-1">Satisfacción</h6>
                        <p class="stat-description-admin mb-0">Clientes felices</p>
                        <div class="position-absolute top-0 end-0 m-3">
                            <i class="fas fa-medal text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-admin border-0 h-100">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="stat-icon-admin bg-info bg-opacity-10 text-info">
                            <i class="fas fa-rocket fs-2"></i>
                        </div>
                        <h3 class="stat-number-admin text-info mb-2">24/7</h3>
                        <h6 class="stat-label-admin mb-1">Disponibilidad</h6>
                        <p class="stat-description-admin mb-0">Sistema activo</p>
                        <div class="position-absolute top-0 end-0 m-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="container mb-5">
        <div class="quick-actions-panel border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-3">
                            <div class="quick-actions-icon me-3">
                                <i class="fas fa-bolt fs-4"></i>
                            </div>
                                                    <div>
                            <h4 class="fw-bold text-light mb-1">Acciones Rápidas</h4>
                            <p class="text-light opacity-75 mb-0">Gestiona tu contenido de manera eficiente</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex gap-2 justify-content-lg-end">
                            <a href="add.php" class="btn-admin-primary text-decoration-none">
                                <i class="fas fa-plus me-2"></i>Agregar Proyecto
                            </a>
                            <a href="../api/proyectos.php" class="btn btn-outline-secondary rounded-pill px-4" target="_blank">
                                <i class="fas fa-code me-2"></i>Ver API
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Management Section -->
    <div class="container mb-5">
        <div class="project-management-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-light mb-1">Gestión de Proyectos</h2>
                    <p class="text-light opacity-75 mb-0">Administra tu portafolio profesional</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="dashboard-badge">
                        <i class="fas fa-database me-2"></i>
                        <?= $result->num_rows ?> proyecto<?= $result->num_rows != 1 ? 's' : '' ?> registrado<?= $result->num_rows != 1 ? 's' : '' ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if($result->num_rows > 0): ?>
            <div class="row g-4">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-xl-4 col-lg-6">
                        <div class="project-card-admin border-0 h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="../uploads/<?= htmlspecialchars($row['imagen']) ?>" 
                                     class="project-image-admin w-100" 
                                     alt="<?= htmlspecialchars($row['titulo']) ?>">
                                <div class="project-overlay-admin">
                                    <div class="text-center text-white">
                                        <i class="fas fa-edit fs-2 mb-2"></i>
                                        <div class="fw-semibold">Gestionar</div>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="project-badge-admin">
                                        ID: <?= $row['id'] ?>
                                    </span>
                                </div>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="project-status-badge">
                                        <i class="fas fa-check me-1"></i>Activo
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="card-title fw-bold text-light mb-3 fs-5">
                                    <?= htmlspecialchars($row['titulo']) ?>
                                </h5>
                                <p class="card-text text-light opacity-75 mb-3 flex-grow-1 lh-lg">
                                    <?= htmlspecialchars(substr($row['descripcion'], 0, 120)) . (strlen($row['descripcion']) > 120 ? '...' : '') ?>
                                </p>
                                
                                <!-- Enlaces del proyecto -->
                                <div class="d-flex gap-2 mb-3">
                                    <?php if(!empty($row['url_github'])): ?>
                                        <a href="<?= htmlspecialchars($row['url_github']) ?>" 
                                           class="btn btn-outline-dark btn-sm flex-fill rounded-pill" 
                                           target="_blank">
                                            <i class="fab fa-github me-1"></i>Código
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($row['url_produccion'])): ?>
                                        <a href="<?= htmlspecialchars($row['url_produccion']) ?>" 
                                           class="btn btn-outline-primary btn-sm flex-fill rounded-pill" 
                                           target="_blank">
                                            <i class="fas fa-external-link-alt me-1"></i>Demo
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Botones de acción -->
                                <div class="d-flex gap-2 mb-3">
                                    <a href="edit.php?id=<?= $row['id'] ?>" 
                                       class="btn-admin-success flex-fill text-decoration-none text-center">
                                        <i class="fas fa-edit me-2"></i>Editar
                                    </a>
                                    
                                    <a href="delete.php?id=<?= $row['id'] ?>" 
                                       class="btn-admin-danger flex-fill text-decoration-none text-center" 
                                       onclick="return confirmDelete('<?= htmlspecialchars($row['titulo']) ?>')">
                                        <i class="fas fa-trash-alt me-2"></i>Eliminar
                                    </a>
                                </div>
                                
                                <!-- Información adicional -->
                                <div class="border-top pt-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-light opacity-75 d-block">
                                                <i class="fas fa-calendar me-1 text-primary"></i>
                                                Creado
                                            </small>
                                            <small class="fw-semibold text-light">
                                                <?= date('d/m/Y', strtotime($row['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-light opacity-75 d-block">
                                                <i class="fas fa-clock me-1 text-info"></i>
                                                Hora
                                            </small>
                                            <small class="fw-semibold text-light">
                                                <?= date('H:i', strtotime($row['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="empty-state-admin">
                    <div class="empty-state-icon">
                        <i class="fas fa-folder-plus"></i>
                    </div>
                    <h3 class="fw-bold text-light mb-3">¡Comienza Tu Portafolio!</h3>
                    <p class="text-light opacity-75 mb-4 fs-5">
                        No tienes proyectos registrados aún. Agrega tu primer proyecto para comenzar 
                        a mostrar tu trabajo increíble al mundo.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="add.php" class="btn-admin-primary text-decoration-none">
                            <i class="fas fa-plus me-2"></i>Agregar Primer Proyecto
                        </a>
                        <a href="../index.php" class="btn btn-outline-secondary btn-lg px-5 rounded-pill">
                            <i class="fas fa-eye me-2"></i>Ver Portafolio
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="admin-footer text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="admin-footer-icon me-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-white">Panel de Administración</h6>
                            <p class="mb-0 text-light opacity-75 small">
                                Sistema seguro para gestionar tu portafolio profesional
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="mb-1 text-light opacity-75">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Desarrollado con Bootstrap 5.3.3
                    </p>
                    <small class="text-light opacity-50">
                        <?= APP_NAME ?> &copy; <?= date('Y') ?> - Todos los derechos reservados
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enhanced Admin Dashboard JavaScript -->
    <script>
        // Enhanced confirmation dialog
        function confirmDelete(projectTitle) {
            return confirm(`🗑️ ¿Estás seguro de eliminar el proyecto "${projectTitle}"?\n\n⚠️ Esta acción no se puede deshacer y eliminará:\n• El proyecto de tu portafolio\n• La imagen asociada\n• Todos los datos relacionados\n\n¿Deseas continuar?`);
        }

        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stats cards on load
            const statsCards = document.querySelectorAll('.stat-card-admin');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Project cards hover effects are handled by CSS
            
            // Stats counter animation
            const statsNumbers = document.querySelectorAll('.stat-number-admin');
            statsNumbers.forEach(stat => {
                const finalValue = stat.textContent;
                const numericValue = parseInt(finalValue.replace(/\D/g, ''));
                
                if (!isNaN(numericValue) && numericValue > 0) {
                    let currentValue = 0;
                    const increment = Math.ceil(numericValue / 30);
                    const suffix = finalValue.replace(/\d/g, '');
                    
                    const counter = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= numericValue) {
                            stat.textContent = finalValue;
                            clearInterval(counter);
                        } else {
                            stat.textContent = currentValue + suffix;
                        }
                    }, 50);
                }
            });
        });
    </script>
</body>
</html> 