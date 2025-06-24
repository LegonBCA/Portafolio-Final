-- ===================================================================
-- SCRIPT DE BASE DE DATOS PARA PORTAFOLIO PERSONAL
-- PROPÓSITO: Crear la estructura inicial de la base de datos
-- ===================================================================

-- Crear la base de datos principal del portafolio
CREATE DATABASE portafolio_db;
-- Seleccionar la base de datos para usar en los siguientes comandos
USE portafolio_db;

-- Tabla de usuarios del sistema
-- Aunque actualmente solo se usa un usuario hardcodeado,
-- esta tabla permite futuras expansiones del sistema de autenticación
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,        -- ID único auto-incremental
  username VARCHAR(50) NOT NULL,            -- Nombre de usuario (máximo 50 caracteres)
  password VARCHAR(255) NOT NULL            -- Contraseña hasheada (MD5 en este caso, aunque recomendable usar bcrypt en producción)
);

-- Tabla principal de proyectos del portafolio
-- Contiene toda la información de cada proyecto mostrado en el portafolio
CREATE TABLE proyectos (
  id INT AUTO_INCREMENT PRIMARY KEY,        -- ID único del proyecto
  titulo VARCHAR(100) NOT NULL,             -- Título del proyecto (obligatorio, máximo 100 caracteres)
  descripcion TEXT NOT NULL,                -- Descripción detallada del proyecto (obligatorio, texto largo)
  url_github VARCHAR(255),                  -- URL del repositorio en GitHub (opcional)
  url_produccion VARCHAR(255),              -- URL del proyecto en producción/demo (opcional)
  imagen VARCHAR(255),                      -- Nombre del archivo de imagen (opcional)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Fecha y hora de creación (automática)
);

-- Usuario de prueba (usuario: admin, contraseña: 123456)
-- Insertar usuario administrador por defecto para poder acceder al sistema
-- NOTA: En producción se debería usar un hash más seguro como bcrypt
INSERT INTO users (username, password) VALUES ('admin', MD5('123456'));