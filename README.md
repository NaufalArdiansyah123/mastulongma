# Mastulongmas - Platform Bantuan Sosial<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Platform bantuan sosial berbasis web dengan tampilan mobile-first (seperti aplikasi mobile) menggunakan Laravel 12, Livewire 3, dan Tailwind CSS.<p align="center">

<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

## 🚀 Fitur Utama<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>

<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>

### 💡 Tampilan Mobile-First<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>

-   Lebar konten dikunci di max-width 420px (seperti tampilan HP)</p>

-   Navigasi bawah (bottom navigation) seperti aplikasi mobile

-   Responsive dan user-friendly## About Laravel

-   Desain minimalis dan humanis dengan warna biru muda

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

### 👥 Sistem Role-Based

-   **Super Admin**: Mengelola admin, kategori, kota, dan biaya langganan- [Simple, fast routing engine](https://laravel.com/docs/routing).

-   **Admin Kota**: Verifikasi KTP, moderasi postingan bantuan- [Powerful dependency injection container](https://laravel.com/docs/container).

-   **Kustomer**: Membuat permintaan bantuan- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.

-   **Mitra**: Mengambil dan menyelesaikan bantuan- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).

-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).

### 📋 Fitur Bantuan- [Robust background job processing](https://laravel.com/docs/queues).

-   Posting permintaan bantuan dengan foto- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

-   Filter berdasarkan kategori dan kota

-   Status tracking (pending → approved → taken → completed)Laravel is accessible, powerful, and provides tools required for large, robust applications.

-   Rating dan review untuk mitra

-   Notifikasi real-time## Learning Laravel

## 📦 Teknologi yang DigunakanLaravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

-   **Backend**: Laravel 12If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

-   **Frontend**: Livewire 3 + Tailwind CSS

-   **Database**: MySQL## Laravel Sponsors

-   **Authentication**: Laravel Breeze (Livewire)

-   **File Storage**: Laravel StorageWe would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

## 🛠️ Instalasi### Premium Partners

### Prerequisites- **[Vehikl](https://vehikl.com)**

-   PHP >= 8.2- **[Tighten Co.](https://tighten.co)**

-   Composer- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**

-   Node.js & NPM- **[64 Robots](https://64robots.com)**

-   MySQL- **[Curotec](https://www.curotec.com/services/technologies/laravel)**

-   XAMPP (atau web server lain)- **[DevSquad](https://devsquad.com/hire-laravel-developers)**

-   **[Redberry](https://redberry.international/laravel-development)**

### Langkah-langkah Instalasi- **[Active Logic](https://activelogic.com)**

1. **Clone atau gunakan project yang sudah ada**## Contributing

```bash

cd c:\xampp\htdocs\mastulongmasThank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

```

## Code of Conduct

2. **Install Dependencies**

```bashIn order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

composer install

npm install## Security Vulnerabilities

```

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

3. **Konfigurasi Environment**

File `.env` sudah dikonfigurasi dengan:## License

-   Database: mastulongmas

-   DB_USERNAME: rootThe Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

-   DB_PASSWORD: (kosong untuk XAMPP default)

4. **Generate Application Key** (sudah dilakukan)

```bash
php artisan key:generate
```

5. **Jalankan Migrations dan Seeders**

```bash
php artisan migrate:fresh --seed
```

6. **Link Storage**

```bash
php artisan storage:link
```

7. **Build Assets**

```bash
npm run build
# atau untuk development
npm run dev
```

8. **Jalankan Server**

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 👤 Akun Default untuk Testing

### Super Admin

-   Email: `superadmin@mastulongmas.com`
-   Password: `password`

### Admin Jakarta

-   Email: `admin.jakarta@mastulongmas.com`
-   Password: `password`

### Kustomer (Pengguna yang Butuh Bantuan)

-   Email: `budi@example.com`
-   Password: `password`

### Mitra (Relawan/Pemberi Bantuan)

-   Email: `ahmad@example.com`
-   Password: `password`

## 📱 Cara Menggunakan Aplikasi

### Sebagai Kustomer (Yang Butuh Bantuan)

1. **Login** dengan akun kustomer
2. Klik **Dashboard** di bottom navigation
3. Klik tombol **"Buat Permintaan Bantuan"**
4. Isi form:
    - Judul bantuan
    - Kategori (Rumah Tangga, Kesehatan, Pangan, dll)
    - Kota
    - Lokasi detail
    - Deskripsi lengkap
    - Foto (opsional)
5. Klik **"Kirim Permintaan"**
6. Menunggu admin memverifikasi (untuk demo, sudah auto-approved)
7. Setelah disetujui, mitra bisa mengambil bantuan Anda
8. Status berubah menjadi "Taken" ketika ada mitra yang mengambil
9. Bisa memberikan rating setelah bantuan selesai

### Sebagai Mitra (Relawan)

1. **Login** dengan akun mitra
2. Klik **"Home"** atau **"Bantuan"** untuk melihat daftar bantuan tersedia
3. Filter berdasarkan kategori atau kota jika perlu
4. Klik tombol **"Ambil Bantuan"** pada bantuan yang ingin Anda berikan
5. Hubungi kustomer (kontak terlihat setelah mengambil bantuan)
6. Setelah selesai membantu, klik **"Tandai Selesai"**
7. Kustomer bisa memberikan rating untuk Anda

### Sebagai Admin Kota

1. **Login** dengan akun admin
2. Verifikasi KTP pengguna baru
3. Moderasi postingan bantuan (approve/reject)
4. Monitor status bantuan di wilayahnya
5. Lihat laporan dan aktivitas

### Sebagai Super Admin

1. **Login** dengan akun super admin
2. Kelola admin kota (CRUD)
3. Kelola kategori bantuan
4. Set biaya langganan untuk mitra premium
5. Lihat statistik keseluruhan

## 📊 Struktur Database

### Tabel Utama

-   `users` - Data pengguna dengan role (super_admin, admin, kustomer, mitra)
-   `cities` - Daftar kota
-   `categories` - Kategori bantuan
-   `helps` - Posting bantuan
-   `subscriptions` - Langganan premium mitra
-   `ratings` - Rating dan review
-   `logs` - Log aktivitas

## 🎨 Customisasi Tampilan

### Warna Utama (Tailwind Config)

File: `tailwind.config.js`

```javascript
colors: {
  primary: {
    500: '#3b82f6', // Biru utama
    600: '#2563eb', // Biru lebih gelap
  }
}
```

### Max Width Container

```javascript
maxWidth: {
  'mobile': '420px', // Lebar maksimal seperti HP
}
```

### Layout Mobile

File: `resources/views/layouts/app.blade.php`

-   Fixed max-width 420px
-   Bottom navigation
-   Sticky header

## 🔧 Development

### Menjalankan Development Server

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite untuk hot reload
npm run dev
```

### Membuat Livewire Component Baru

```bash
php artisan make:livewire NamaComponent
```

### Menambah Migration Baru

```bash
php artisan make:migration create_nama_table
php artisan migrate
```

## 🎯 Fitur yang Sudah Diimplementasikan

✅ Sistem autentikasi dengan Laravel Breeze
✅ Role-based access control (super_admin, admin, kustomer, mitra)
✅ Tampilan mobile-first dengan max-width 420px
✅ Bottom navigation seperti aplikasi mobile
✅ Halaman home dengan daftar bantuan
✅ Filter bantuan berdasarkan kategori dan kota
✅ Dashboard untuk kustomer dan mitra
✅ Form create permintaan bantuan (dengan upload foto)
✅ Mitra bisa ambil dan selesaikan bantuan
✅ Status tracking bantuan
✅ Seeder data sample (cities, categories, users, helps)

## 🚧 Fitur yang Masih Dalam Pengembangan

-   [ ] Super Admin dashboard dan CRUD lengkap
-   [ ] Admin Kota dashboard untuk verifikasi KTP dan moderasi
-   [ ] Sistem rating dan review lengkap
-   [ ] Notifikasi real-time (Laravel Echo + Pusher)
-   [ ] Upload dan verifikasi KTP otomatis
-   [ ] Sistem langganan premium untuk mitra
-   [ ] Export laporan PDF
-   [ ] Chat antara kustomer dan mitra
-   [ ] Maps integration untuk lokasi
-   [ ] Push notification

## 📝 Catatan Penting

1. **Verifikasi KTP**: Saat ini semua user test sudah di-set `verified = true`
2. **Auto Approve**: Untuk demo, posting bantuan langsung approved (status = 'approved')
3. **File Upload**: Jangan lupa jalankan `php artisan storage:link`
4. **Bottom Navigation**: Hanya tampil untuk user yang sudah login
5. **Mobile View**: Buka di browser dengan width kecil atau gunakan dev tools mobile view untuk pengalaman terbaik
6. **Sample Data**: Sudah ada 5 sample posting bantuan dari kustomer "Budi Santoso"

## 🏃 Quick Start

```bash
# 1. Install dependencies
composer install && npm install

# 2. Setup database
php artisan migrate:fresh --seed

# 3. Link storage
php artisan storage:link

# 4. Build assets
npm run build

# 5. Run server
php artisan serve
```

Buka `http://localhost:8000` dan login dengan salah satu akun di atas!

## 🤝 Kontribusi

Aplikasi ini dibuat untuk tujuan pembelajaran dan sosial. Silakan fork dan kembangkan sesuai kebutuhan Anda!

## 📄 Lisensi

Open source untuk tujuan pembelajaran dan kemanusiaan.

## 📞 Support

Untuk pertanyaan atau bantuan, silakan buat issue di repository ini.

---

**Dibuat dengan ❤️ untuk Indonesia yang lebih baik**
