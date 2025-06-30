# BengkelKita

BengkelKita adalah sistem manajemen bengkel mobil modern berbasis web yang dirancang untuk menyederhanakan dan mengoptimalkan seluruh alur kerja operasional bengkel. Aplikasi ini menjembatani komunikasi antara pelanggan, teknisi, dan admin melalui sebuah platform digital yang terpusat dan mudah digunakan.

---

### **Persyaratan Sistem**

Pastikan perangkat Anda telah memenuhi semua persyaratan berikut sebelum memulai instalasi:

- **PHP**: Minimal versi **8.2**
- **Web Server**: **XAMPP** atau perangkat sejenis sudah terinstal.
  - [Download XAMPP di sini](https://www.apachefriends.org/download.html)
- **Composer**: Sudah terinstal secara global di komputer.
  - [Unduh Composer di sini](https://getcomposer.org/download/)
- **Node.js & NPM**: Sudah terinstal (NPM sudah termasuk dalam instalasi Node.js).
  - [Unduh Node.js di sini](https://nodejs.org/en/download/)

---

### **Langkah-Langkah Instalasi**

Ikuti langkah-langkah berikut secara berurutan untuk menjalankan aplikasi di lingkungan lokal Anda.

**1. Clone Repository**
   Buka terminal atau Git Bash, lalu jalankan perintah berikut untuk mengunduh kode sumber proyek.
   ```bash
   git clone https://github.com/azizt91/bengkel-app.git
   ```

**2. Masuk ke Direktori Proyek**
   ```bash
   cd bengkel-app
   ```

**3. Instal Dependensi PHP (Backend)**
   Jalankan Composer untuk mengunduh semua library PHP yang dibutuhkan.
   ```bash
   composer install
   ```

**4. Instal Dependensi JavaScript (Frontend)**
   Jalankan NPM untuk mengunduh semua library JavaScript. Langkah ini penting untuk meng-compile CSS dan JS.
   ```bash
   npm install
   ```

**5. Buat File Konfigurasi Lingkungan (`.env`)**
   Salin file contoh `.env.example` untuk membuat file konfigurasi utama aplikasi.
   ```bash
   cp .env.example .env
   ```

**6. Generate Application Key**
   Buat kunci enkripsi unik untuk aplikasi Anda.
   ```bash
   php artisan key:generate
   ```

**7. Siapkan Database**
   - Buka **phpMyAdmin** atau _database management tool_ lainnya.
   - Buat sebuah database baru. Contoh nama: `bengkelkita_db`.
   - **Import** file `db/laravel.sql` yang ada di dalam folder proyek ke dalam database yang baru saja Anda buat.

**8. Konfigurasi Koneksi Database**
   Buka file `.env` dan sesuaikan konfigurasinya agar cocok dengan database yang telah Anda siapkan pada langkah sebelumnya.
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel        # <-- Ganti dengan nama database Anda
   DB_USERNAME=root            # <-- Ganti dengan username database Anda
   DB_PASSWORD=               # <-- Ganti dengan password database Anda (kosongkan jika tidak ada)
   ```

**9. Compile Aset Frontend**
   Jalankan perintah `build` untuk meng-compile file-file seperti CSS dan JavaScript agar siap digunakan.
   ```bash
   npm run build
   ```

**10. Buat Symbolic Link untuk Storage**
    Perintah ini akan membuat "pintasan" agar file yang di-upload (seperti foto profil atau bukti servis) dapat diakses dari web.
    
    ```bash
    php artisan storage:link
    ```

**11. Jalankan Server Development**
    Terakhir, jalankan server lokal Laravel.
    
    ```bash
    php artisan serve
    ```

**12. Akses Aplikasi**
    Buka browser Anda dan kunjungi alamat yang muncul di terminal, biasanya:
    [**http://127.0.0.1:8000**](http://127.0.0.1:8000)

---

### **Akun Default untuk Login**

Anda dapat menggunakan akun berikut untuk login dan mencoba fitur aplikasi:

- **Admin**
  - **Email**: `admin@example.com`
  - **Password**: `password`

- **Teknisi**
  - **Email**: `tech@example.com`
  - **Password**: `password`

- **Pelanggan**
  - **Email**: `customer@example.com`
  - **Password**: `password`

---

## **License**
Proyek ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
