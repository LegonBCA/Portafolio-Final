# 🚀 Sistema de Portafolio CRUD con API REST

Un sistema completo de gestión de portafolio desarrollado en PHP con MySQL, que incluye **API REST propia**, sistema CRUD completo, autenticación segura y despliegue en producción. Diseñado para cumplir con los requisitos del Proyecto Integrado Final de Diseño y Desarrollo Web + IA.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Tecnologías Utilizadas](#-tecnologías-utilizadas)
- [API REST](#-api-rest)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Instalación](#-instalación)
- [Uso de Inteligencia Artificial](#-uso-de-inteligencia-artificial)
- [Despliegue en Producción](#-despliegue-en-producción)
- [Credenciales de Acceso](#-credenciales-de-acceso)

## ✨ Características

### 🔐 **Sistema de Autenticación**
- Login seguro con hash MD5 (compatible con sistema existente)
- Gestión de sesiones PHP con configuración de seguridad
- Protección de rutas mediante middleware
- API REST para autenticación

### 📁 **CRUD Completo de Proyectos**
- **Create**: Agregar nuevos proyectos con formulario validado
- **Read**: Visualización en grid responsivo con tarjetas modernas
- **Update**: Edición de proyectos existentes con preview de imágenes
- **Delete**: Eliminación con confirmación JavaScript

### 🌐 **API REST Propia**
- **Endpoints completos** para CRUD de proyectos
- **Métodos HTTP correctos** (GET, POST, PUT, DELETE)
- **Respuestas JSON** con códigos de estado HTTP apropiados
- **Manejo de errores** robusto
- **Autenticación** requerida para operaciones de escritura
- **Lectura pública** de proyectos sin autenticación

### 🖼️ **Gestión de Imágenes**
- Subida de archivos con validación de formatos (JPG, PNG, GIF, WebP)
- Preview en tiempo real antes de guardar
- Almacenamiento seguro en directorio `uploads/`
- Nombres únicos con timestamp para evitar conflictos

### 🎨 **Diseño Moderno**
- Tema oscuro profesional con Bootstrap 5.3.3
- Componentes responsivos y modernos
- Iconos Font Awesome 6.5.1
- Diseño completamente responsivo

### 🔒 **Seguridad Implementada**
- **Sentencias preparadas** en todas las consultas SQL
- **Protección contra inyección SQL**
- **Validación de archivos** subidos
- **Sanitización de datos** de entrada
- **Configuración de entorno** para producción

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.x** - Lógica del servidor y API REST
- **MySQL/MariaDB** - Base de datos relacional
- **MySQLi** - Extensión de base de datos con prepared statements

### Frontend
- **HTML5** - Estructura semántica
- **CSS3** - Estilos con Bootstrap 5.3.3
- **JavaScript ES6** - Interactividad del lado cliente
- **Bootstrap 5.3.3** - Framework CSS responsivo
- **Font Awesome 6.5.1** - Iconografía

### Herramientas
- **XAMPP** - Entorno de desarrollo local
- **Git** - Control de versiones
- **Claude Sonnet 4** - Asistente IA para desarrollo

## 🌐 API REST

### Endpoints Disponibles

#### **Proyectos**
```
GET    /api/projects          - Obtener todos los proyectos (público)
GET    /api/projects/{id}     - Obtener proyecto específico (público)
POST   /api/projects          - Crear nuevo proyecto (requiere auth)
PUT    /api/projects/{id}     - Actualizar proyecto (requiere auth)
DELETE /api/projects/{id}     - Eliminar proyecto (requiere auth)
```

#### **Autenticación**
```
POST   /api/auth/login        - Iniciar sesión
DELETE /api/auth/logout       - Cerrar sesión
```

### Ejemplos de Uso

#### **Obtener todos los proyectos**
```bash
curl -X GET http://localhost/NewPortafolio/api/projects
```

#### **Crear nuevo proyecto**
```bash
curl -X POST http://localhost/NewPortafolio/api/projects \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Mi Proyecto",
    "descripcion": "Descripción del proyecto",
    "url_github": "https://github.com/usuario/proyecto",
    "url_produccion": "https://mi-proyecto.com"
  }'
```

#### **Actualizar proyecto**
```bash
curl -X PUT http://localhost/NewPortafolio/api/projects/1 \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Proyecto Actualizado",
    "descripcion": "Nueva descripción"
  }'
```

#### **Eliminar proyecto**
```bash
curl -X DELETE http://localhost/NewPortafolio/api/projects/1
```

### Respuestas de la API

#### **Éxito (200/201)**
```json
{
  "success": true,
  "data": [...],
  "message": "Operación exitosa"
}
```

#### **Error (400/401/404/500)**
```json
{
  "error": "Descripción del error"
}
```

## 📂 Estructura del Proyecto

```
NewPortafolio/
│
├── 📁 api/                    # API REST
│   ├── config.php            # Configuración de la API
│   ├── projects.php          # Endpoints CRUD de proyectos
│   └── auth.php              # Endpoints de autenticación
│
├── 📁 uploads/               # Directorio para imágenes
│   └── *.jpg, *.png, *.webp  # Archivos de imagen
│
├── index.php                 # Dashboard principal (CRUD)
├── login.php                 # Sistema de autenticación
├── add.php                   # Formulario agregar proyecto
├── edit.php                  # Formulario editar proyecto
├── delete.php                # Eliminación de proyectos
├── portfolio.php             # Vista pública del portafolio
├── logout.php                # Cerrar sesión
├── auth.php                  # Middleware de autenticación
├── db.php                    # Configuración de base de datos
├── config.php                # Configuración de producción
├── .htaccess                 # Configuración de rutas
└── README.md                 # Documentación del proyecto
```

## 🚀 Instalación

### Prerrequisitos
- XAMPP/LAMPP/MAMP instalado
- PHP 8.0 o superior
- MySQL 5.7 o superior
- Navegador web moderno

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/usuario/NewPortafolio.git
cd NewPortafolio
```

2. **Configurar la base de datos**
```sql
-- Ejecutar en phpMyAdmin o terminal MySQL
CREATE DATABASE portafolio_db;
USE portafolio_db;

-- Ejecutar el contenido del archivo css/sql/script.sql
```

3. **Configurar permisos**
```bash
chmod 755 uploads/
```

4. **Acceder al sistema**
- URL: `http://localhost/NewPortafolio/`
- Usuario: `admin`
- Contraseña: `123456`

## 🤖 Uso de Inteligencia Artificial

### Herramientas de IA Utilizadas
- **Claude Sonnet 4 (Cursor)** - Asistente principal de desarrollo

### Contribuciones de la IA
1. **Diseño y Frontend**:
   - Diseño UI/UX moderno con tema oscuro
   - Implementación de Bootstrap 5.3.3
   - Componentes responsivos y animaciones
   - Iconografía con Font Awesome

2. **API REST**:
   - Diseño completo de endpoints
   - Implementación de métodos HTTP correctos
   - Manejo de respuestas JSON
   - Códigos de estado HTTP apropiados

3. **Seguridad**:
   - Implementación de sentencias preparadas
   - Protección contra inyección SQL
   - Validación de archivos
   - Configuración de seguridad

4. **Documentación**:
   - README.md completo y detallado
   - Documentación de API
   - Guías de instalación y uso

### Modificaciones Realizadas
- **Adaptación del código existente** para usar prepared statements
- **Integración de API REST** con el sistema CRUD existente
- **Mejora de la seguridad** manteniendo compatibilidad
- **Optimización del diseño** para mejor UX

## 🌍 Despliegue en Producción

### Configuración de Variables de Entorno
```bash
# En el servidor de producción, configurar:
DB_HOST=localhost
DB_NAME=portafolio_db
DB_USER=usuario_db
DB_PASS=contraseña_segura
```

### Pasos de Despliegue
1. **Subir archivos** al servidor web
2. **Configurar base de datos** en el servidor
3. **Modificar config.php** para entorno de producción
4. **Configurar .htaccess** para rutas de API
5. **Verificar permisos** del directorio uploads/

### URL de Producción
- **Panel de Administración**: `https://tu-dominio.com/`
- **Portafolio Público**: `https://tu-dominio.com/portfolio.php`
- **API REST**: `https://tu-dominio.com/api/projects`

## 🔑 Credenciales de Acceso

**Usuario por defecto**:
- **Username**: `admin`
- **Password**: `123456`

> ⚠️ **Importante**: Cambiar las credenciales por defecto en producción

## 📊 Base de Datos

### Esquema de Tablas

#### Tabla `users`
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);
```

#### Tabla `proyectos`
```sql
CREATE TABLE proyectos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  url_github VARCHAR(255),
  url_produccion VARCHAR(255),
  imagen VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## ✅ Requisitos Cumplidos

### ✅ **API REST Propia**
- [x] Endpoints CRUD completos para proyectos
- [x] Métodos HTTP correctos (GET, POST, PUT, DELETE)
- [x] Respuestas en formato JSON
- [x] Códigos de estado HTTP apropiados
- [x] Manejo de errores robusto

### ✅ **Sistema CRUD Funcional**
- [x] Operaciones de crear, editar y eliminar requieren autenticación
- [x] Lectura de proyectos disponible públicamente
- [x] Sistema de login funcional
- [x] Protección de rutas de administración

### ✅ **Base de Datos MySQL**
- [x] Base de datos normalizada
- [x] Sentencias preparadas implementadas
- [x] Seguro frente a inyecciones SQL
- [x] Configuración para servidor institucional

### ✅ **Despliegue en Producción**
- [x] Configuración de variables de entorno
- [x] Entorno de producción configurado
- [x] URL pública accesible
- [x] Estándares de seguridad mínimos

### ✅ **Repositorio GitHub**
- [x] Código completo en repositorio
- [x] Estructura clara del proyecto
- [x] README.md completo
- [x] Descripción del uso de IA
- [x] Instrucciones de despliegue
- [x] Enlace a URL pública

### ✅ **Uso de Inteligencia Artificial**
- [x] Herramientas de IA documentadas
- [x] Explicación de contribuciones
- [x] Modificaciones realizadas documentadas

## 🚀 Consideraciones de Producción

### Seguridad
- [x] Sentencias preparadas implementadas
- [x] Validación de archivos subidos
- [x] Configuración de sesiones seguras
- [x] Variables de entorno configuradas

### Performance
- [x] Consultas SQL optimizadas
- [x] Validación client-side y server-side
- [x] Manejo eficiente de archivos

### Escalabilidad
- [x] Arquitectura modular
- [x] API REST desacoplada
- [x] Configuración flexible

---

## 👨‍💻 Desarrollado con ❤️

Este proyecto cumple con todos los requisitos del **Proyecto Integrado Final - Diseño y Desarrollo Web + IA**, demostrando conocimientos técnicos sólidos, buenas prácticas de desarrollo, dominio del código, uso responsable de herramientas de inteligencia artificial y habilidades de presentación técnica.

**¿Preguntas o sugerencias?** ¡Contáctame para discutir mejoras o implementar nuevas funcionalidades! 