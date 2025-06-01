-- Database Schema untuk Sistem Informasi Geospatial
-- Tugas Mata Kuliah SIG

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS sig_app 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Gunakan database
USE sig_app;

-- Tabel untuk menyimpan data GIS
CREATE TABLE IF NOT EXISTS gis_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Nama feature geografis',
    type ENUM('polygon', 'polyline', 'marker') NOT NULL COMMENT 'Jenis geometri',
    geometry JSON NOT NULL COMMENT 'Data koordinat dalam format GeoJSON',
    area VARCHAR(50) NULL COMMENT 'Luas area untuk polygon',
    description TEXT NULL COMMENT 'Deskripsi tambahan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu pembuatan',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Waktu update terakhir'
) ENGINE=InnoDB COMMENT='Tabel penyimpanan data geospasial';

-- Index untuk optimasi query
CREATE INDEX idx_type ON gis_data(type);
CREATE INDEX idx_created_at ON gis_data(created_at);

-- Insert sample data
INSERT INTO gis_data (name, type, geometry, area) VALUES 
('Contoh Polygon', 'polygon', '{"type":"Polygon","coordinates":[[[109.3425,-0.0263],[109.3525,-0.0263],[109.3525,-0.0163],[109.3425,-0.0163],[109.3425,-0.0263]]]}', '1.24 km²'),
('Contoh Marker', 'marker', '{"type":"Point","coordinates":[109.3425,-0.0263]}', NULL);