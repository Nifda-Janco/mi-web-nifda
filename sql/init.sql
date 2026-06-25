CREATE DATABASE IF NOT EXISTS mi_sitio;
USE mi_sitio;

CREATE TABLE IF NOT EXISTS tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    completada TINYINT(1) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tareas (titulo, descripcion) VALUES
('Aprender Docker', 'Practicar con docker-compose'),
('Crear sitio web', 'PHP + MySQL + HTML');