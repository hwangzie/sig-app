# Setup Guide - Sistem Informasi Geospatial

## Langkah-langkah Instalasi Detail

### 1. Persiapan Environment

1. **Install XAMPP**
   - Download dari [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install dengan setting default
   - Start Apache dan MySQL dari XAMPP Control Panel

2. **Verify Installation**
   - Buka browser, akses `http://localhost`
   - Pastikan halaman XAMPP muncul

### 2. Setup Database

1. **Buka phpMyAdmin**
   - Akses `http://localhost/phpmyadmin`
   - Login dengan username: `root`, password: (kosong)

2. **Import Database**
   - Klik tab "Import"
   - Pilih file `database/schema.sql`
   - Klik "Go"

### 3. Konfigurasi Project

1. **Clone/Copy Project**
   ```bash
   # Jika menggunakan Git
   git clone [repository-url]
   
   # Atau copy manual ke folder
   C:\xampp\htdocs\sig-app\
   ```

2. **Test Connection**
   - Akses `http://localhost/sig-app/public/`
   - Pastikan peta muncul tanpa error

### 4. Troubleshooting

**Problem**: Database connection error
**Solution**: 
- Pastikan MySQL service running di XAMPP
- Check kredensial di `config/database.php`

**Problem**: Peta tidak muncul
**Solution**:
- Check console browser untuk error JavaScript
- Pastikan internet connection untuk load map tiles

**Problem**: Cannot save data
**Solution**:
- Check file permissions
- Verify database table exists