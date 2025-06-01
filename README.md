# Sistem Informasi Geospatial (SIG) - Web GIS CRUD Application

> **Tugas Mata Kuliah Sistem Informasi Geospatial**  
> Program Studi: Teknik Informatika
> Universitas: Tanjungpura 
> Semester: 6/2025

## 📋 Deskripsi Project

Aplikasi web-based Geographic Information System (GIS) yang memungkinkan pengguna untuk melakukan operasi Create, Read, Update, dan Delete (CRUD) pada data spasial. Aplikasi ini dibangun menggunakan PHP, MySQL, dan Leaflet.js sebagai library peta interaktif.

## 🎯 Tujuan Pembelajaran

- Memahami konsep dasar Sistem Informasi Geospatial
- Implementasi web GIS menggunakan teknologi open source
- Mengelola data spasial dalam database
- Visualisasi dan manipulasi data geografis di web browser

## ✨ Fitur Utama

- 🗺️ Peta interaktif dengan kontrol zoom dan pan
- ✏️ Drawing tools untuk menggambar polygon, polyline, dan marker
- 📊 Kalkulasi luas otomatis untuk polygon
- 💾 Penyimpanan data spasial ke database MySQL
- 🔄 Update dan delete data geospasial
- 📱 Responsive design untuk berbagai device

## 🛠️ Teknologi yang Digunakan

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Web Server**: Apache (XAMPP)
- **Mapping Library**: Leaflet.js 1.9.4
- **Drawing Plugin**: Leaflet.Draw 1.0.4
- **Geometry Calculation**: Turf.js 6.0

## 📋 Prerequisites

- XAMPP atau server dengan PHP dan MySQL
- Web browser modern (Chrome, Firefox, Safari, Edge)
- Text editor atau IDE (VS Code, Sublime Text, dll)

## 🚀 Instalasi dan Setup

1. **Clone repository**
   ```bash
   git clone https://github.com/username/sig-app.git
   cd sig-app
   ```

2. **Setup database**
   - Buka phpMyAdmin atau MySQL client
   - Import file `database/schema.sql`
   - Atau jalankan script SQL berikut:
   ```sql
   CREATE DATABASE sig_app;
   USE sig_app;
   
   CREATE TABLE gis_data (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       type ENUM('polygon', 'polyline', 'marker') NOT NULL,
       geometry JSON NOT NULL,
       area VARCHAR(50) NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

3. **Konfigurasi database**
   - Edit file `config/database.php`
   - Sesuaikan kredensial database Anda

4. **Jalankan aplikasi**
   - Pastikan XAMPP Apache dan MySQL sudah running
   - Akses `http://localhost/sig-app/public/`

## 📖 Cara Penggunaan

1. **Menambah Data Spasial**
   - Klik tool drawing di sebelah kiri peta
   - Pilih jenis geometri (polygon, polyline, atau marker)
   - Gambar di peta sesuai kebutuhan
   - Masukkan nama untuk feature tersebut
   - Data akan tersimpan otomatis

2. **Melihat Informasi**
   - Klik pada feature yang ada di peta
   - Popup akan menampilkan informasi detail

3. **Menghapus Data**
   - Klik feature di peta
   - Klik tombol "Hapus" di popup
   - Konfirmasi penghapusan

## 📊 Struktur Database

```sql
gis_data (
    id: INT PRIMARY KEY AUTO_INCREMENT,
    name: VARCHAR(255) - Nama feature,
    type: ENUM - Jenis geometri (polygon/polyline/marker),
    geometry: JSON - Data koordinat dalam format GeoJSON,
    area: VARCHAR(50) - Luas area (untuk polygon),
    created_at: TIMESTAMP - Waktu pembuatan
)
```

## 🔧 API Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/get_data.php` | Mengambil semua data GIS |
| POST | `/api/save.php` | Menyimpan data GIS baru |
| POST | `/api/update.php` | Update data GIS |
| POST | `/api/delete.php` | Hapus data GIS |

## 🚧 Development Roadmap

- [ ] Implementasi user authentication
- [ ] Export data ke format shapefile
- [ ] Layer management system
- [ ] Advanced styling options
- [ ] Mobile app companion

## 🤝 Kontributor

- **[Nama Mahasiswa]** - NIM: [NIM] - [Email]
- **Dosen Pembimbing**: [Nama Dosen] - [Email]

## 📝 Laporan dan Dokumentasi

- [Laporan Project](docs/laporan-project.pdf)
- [Setup Guide](docs/setup.md)
- [User Manual](docs/user-manual.md)

## 📄 License

Project ini dibuat untuk keperluan akademik mata kuliah Sistem Informasi Geospatial.

## 🙏 Acknowledgments

- Terima kasih kepada dosen pengampu mata kuliah SIG
- Leaflet.js community untuk library yang sangat baik
- OpenStreetMap untuk tile layer gratis

---

**Catatan**: Project ini merupakan bagian dari tugas mata kuliah dan dibuat untuk tujuan pembelajaran.