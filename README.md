# BengkelKita

BengkelKita adalah sistem manajemen bengkel mobil modern berbasis web yang dirancang untuk menyederhanakan dan mengoptimalkan seluruh alur kerja operasional bengkel. Aplikasi ini menjembatani komunikasi antara pelanggan, teknisi, dan admin melalui sebuah platform digital yang terpusat dan mudah digunakan.

---

### **Persyaratan Sistem**
- PHP minimal versi **8.2**  
- Sudah terinstal **XAMPP** atau perangkat sejenis  
  [Download XAMPP di sini](https://www.apachefriends.org/download.html)  
- Composer telah terinstal di komputer  
  [Unduh Composer di sini](https://getcomposer.org/download/)  

---

### **Langkah Instalasi**
1. **Clone repository**:
   ```bash
   git clone https://github.com/azizt91/bengkel-app.git
   ```
2. **Masuk ke folder proyek**:
   ```bash
   cd bengkel-app
   ```
3. **Instal dependensi Laravel menggunakan Composer**:
   ```bash
   composer install
   ```
4. **Buat file `.env` dari contoh**:
   ```bash
   cp .env.example .env
   ```
5. **Buat database baru di phpMyAdmin**:
   - Masuk ke phpMyAdmin dan buat database baru sesuai kebutuhan.
   - Import file SQL dari folder `db/laravel.sql` ke dalam database.

6. **Sesuaikan konfigurasi database di file `.env`**:
   Edit baris berikut di file `.env` agar sesuai dengan database yang telah kamu buat:
   ```env
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

8. **Membuat symlink (symbolic link)**:
   Agar file bisa di akses dari URL publik
   ```bash
   php artisan storage:link
   ```

9. **Jalankan aplikasi lokal**:
    ```bash
    php artisan serve
       ```

10. Aplikasi akan dapat diakses biasanya di
    ```bash
    http://127.0.0.1:8000
     ```

12. **Informasi Login Admin Default**:
    
• Admin
email : admin@example.com – password : password

• Teknisi
email : tech@example.com – password : password

• Pelanggan
email : customer@example.com – password : password

---

## License
[MIT license](https://opensource.org/licenses/MIT).
