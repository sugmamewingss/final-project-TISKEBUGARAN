# 🏋️‍♂️ Jurnal Kebugaran App (Fitness Journal API)

> **Proyek Akhir Mata Kuliah Teknologi Integrasi Sistem (TIS)**
> 
> Aplikasi pencatatan jadwal dan log latihan beban yang mengimplementasikan arsitektur *microservices* sederhana, API Gateway, JWT Authentication, dan integrasi API Pihak Ketiga.

---

## 🚀 Fitur Utama & Pemenuhan Kriteria Tugas
Proyek ini dikembangkan untuk memenuhi standar integrasi sistem dengan implementasi berikut:
1. **Backend API (Laravel & MySQL):** Menyediakan RESTful API lengkap untuk entitas utama.
2. **API Gateway (Node.js & Express):** Bertindak sebagai *single entry point* (`Port 3000`) yang merutekan request klien ke backend (`Port 8000`).
3. **Autentikasi & Otorisasi JWT:** Proteksi endpoint menggunakan JSON Web Token (JWT) dengan pembagian Role (Admin & Member).
4. **Integrasi API Pihak Ketiga:** Terhubung secara dinamis dengan **Wger Fitness API** untuk memberikan rekomendasi gerakan cerdas secara acak setiap kali member mencatat log latihan.
5. **Client Web (HTML, JS, Axios):** Antarmuka pengguna sederhana untuk interaksi sistem (Login, Lihat Daftar Gerakan, Tarik Data).
6. **Dokumentasi OpenAPI/Swagger:** Antarmuka interaktif UI Swagger untuk pengujian seluruh *endpoint* sistem.
7. **Error Handling & Validasi:** Validasi form dinamis dengan format response JSON yang konsisten (Success/Error).

---

## 🏗️ Arsitektur Sistem & Struktur Direktori

Proyek ini dipisah menjadi tiga layanan/direktori utama:

```text
final-project-TISKEBUGARAN/
│
├── api-gateway/       # Layanan API Gateway (Node.js, Express, Http-Proxy)
├── backend-api/       # Layanan Inti/Backend (Laravel 10, MySQL)
└── client-web/        # Layanan Klien & Dokumentasi (HTML, Vanilla JS, Swagger)
```

---

## 🛠️ Persyaratan Sistem (Prerequisites)
Pastikan sistem Anda telah terinstal perangkat lunak berikut sebelum memulai:
* [PHP](https://www.php.net/) (v8.1 atau lebih baru)
* [Composer](https://getcomposer.org/)
* [Node.js & npm](https://nodejs.org/) (v16 atau lebih baru)
* [MySQL / MariaDB](https://www.mysql.com/) (Bisa menggunakan XAMPP/Laragon)
* Web Browser modern (Chrome/Edge/Firefox)

---

## ⚙️ Panduan Instalasi & Menjalankan Aplikasi

Langkah-langkah untuk menginstal dan menjalankan proyek di mesin lokal Anda.

### Tahap 1: Persiapan Database
1. Buka MySQL / phpMyAdmin.
2. Buat database baru dengan nama: `db_kebugaran`.

### Tahap 2: Konfigurasi Backend (Laravel)
1. Buka terminal dan masuk ke folder backend:
   ```bash
   cd backend-api
   ```
2. Instal dependensi PHP:
   ```bash
   composer install
   ```
3. Salin file environment dan *generate key* aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```
4. Buka file `.env` dan pastikan konfigurasi database sudah benar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_kebugaran
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Lakukan migrasi tabel beserta data *seeder* (Admin & Member):
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Jalankan server backend (Biarkan terminal ini tetap menyala):
   ```bash
   php artisan serve
   ```
   *Backend kini berjalan secara tertutup di `http://127.0.0.1:8000`*

### Tahap 3: Konfigurasi API Gateway (Node.js)
1. Buka **Terminal Baru**, lalu masuk ke folder gateway:
   ```bash
   cd api-gateway
   ```
2. Instal dependensi Node:
   ```bash
   npm install
   ```
3. Jalankan server Gateway (Biarkan terminal ini tetap menyala):
   ```bash
   node server.js
   ```
   *Gateway kini siap menerima request publik di `http://127.0.0.1:3000`*

### Tahap 4: Mengakses Client Web & Dokumentasi
Tidak perlu instalasi khusus untuk klien.
1. Buka folder `client-web` melalui File Explorer komputer Anda.
2. **Aplikasi Klien:** Klik dua kali (*double-click*) pada file `index.html` untuk mencoba fitur login dan melihat data.
3. **Dokumentasi API:** Klik dua kali pada file `swagger.html` untuk melihat dokumentasi API interaktif.

---

## 🔐 Akun Default (Testing)
Gunakan akun berikut untuk menguji coba sistem (Login via Klien atau Swagger):

* **Admin:** * Email: `admin@kebugaran.com`
  * Password: `password123`
* **Member:** * Email: `member@kebugaran.com`
  * Password: `password123`

---

## 🌐 Dokumentasi Endpoints Utama
Seluruh *request* dari luar diwajibkan melewati jalur API Gateway (`/api`).

| Method | Endpoint Target | Role Akses | Keterangan |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/auth/login` | Publik | Mendapatkan token JWT |
| `GET` | `/api/auth/me` | Authenticated | Melihat profil user aktif |
| `POST` | `/api/auth/logout` | Authenticated | Invalidate token |
| `GET` | `/api/exercises` | Authenticated | Melihat daftar master gerakan |
| `POST` | `/api/exercises` | **Admin** | Menambah daftar gerakan baru |
| `POST` | `/api/workouts` | **Member** | Mencatat log latihan & trigger Wger API |

*(Detail skema request dan response dapat dilihat langsung melalui antarmuka `swagger.html`)*

---

*Project developed with ❤️ for Information Systems Integration Course.*
