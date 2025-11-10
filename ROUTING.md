# ROUTING GUIDE - Mastulongmas

## 📍 Daftar Route yang Tersedia

### Public Routes (Tidak perlu login)

1. **Welcome/Landing Page**

    - URL: `/welcome`
    - Route Name: `welcome`
    - Deskripsi: Halaman landing untuk pengguna baru

2. **Home Page**
    - URL: `/`
    - Route Name: `home`
    - Deskripsi: Halaman utama dengan daftar bantuan tersedia
    - Livewire Component: `Home\Index`

### Auth Routes (Dari Laravel Breeze)

3. **Login**

    - URL: `/login`
    - Route Name: `login`
    - Deskripsi: Halaman login

4. **Register**

    - URL: `/register`
    - Route Name: `register`
    - Deskripsi: Halaman registrasi pengguna baru

5. **Forgot Password**

    - URL: `/forgot-password`
    - Route Name: `password.request`

6. **Reset Password**

    - URL: `/reset-password/{token}`
    - Route Name: `password.reset`

7. **Verify Email**

    - URL: `/verify-email`
    - Route Name: `verification.notice`

8. **Logout**
    - Method: POST
    - URL: `/logout`
    - Route Name: `logout`

### Authenticated Routes (Harus login)

9. **Dashboard**

    - URL: `/dashboard`
    - Route Name: `dashboard`
    - Middleware: `auth`, `verified`
    - Deskripsi: Dashboard utama setelah login
    - Livewire Component: `Dashboard`

10. **Daftar Bantuan (untuk Kustomer)**

    - URL: `/helps`
    - Route Name: `helps.index`
    - Middleware: `auth`, `verified`
    - Deskripsi: Lihat daftar bantuan yang dibuat
    - Livewire Component: `Helps\Index`

11. **Buat Permintaan Bantuan (Khusus Kustomer)**

    - URL: `/helps/create`
    - Route Name: `helps.create`
    - Middleware: `auth`, `verified`, `kustomer`
    - Deskripsi: Form untuk membuat permintaan bantuan baru
    - Livewire Component: `Helps\Create`

12. **Bantuan Tersedia (Khusus Mitra)**

    - URL: `/helps/available`
    - Route Name: `helps.available`
    - Middleware: `auth`, `verified`, `mitra`
    - Deskripsi: Lihat bantuan yang bisa diambil oleh mitra
    - Livewire Component: `Helps\Index`

13. **Profile**

    - URL: `/profile`
    - Route Name: `profile`
    - Middleware: `auth`
    - Deskripsi: Halaman profil pengguna

14. **Edit Profile**
    - URL: `/profile/edit`
    - Route Name: `profile.edit`
    - Middleware: `auth`
    - Deskripsi: Edit profil pengguna (sama dengan profile)

## 🔒 Middleware yang Digunakan

### 1. auth

-   Memastikan pengguna sudah login
-   Redirect ke `/login` jika belum login

### 2. verified

-   Memastikan email sudah diverifikasi
-   Redirect ke `/verify-email` jika belum verify

### 3. kustomer

-   Memastikan role = 'kustomer'
-   Return 403 jika bukan kustomer
-   File: `app/Http/Middleware/EnsureKustomer.php`

### 4. mitra

-   Memastikan role = 'mitra'
-   Return 403 jika bukan mitra
-   File: `app/Http/Middleware/EnsureMitra.php`

### 5. admin

-   Memastikan role = 'admin'
-   Return 403 jika bukan admin
-   File: `app/Http/Middleware/EnsureAdmin.php`

### 6. super_admin

-   Memastikan role = 'super_admin'
-   Return 403 jika bukan super admin
-   File: `app/Http/Middleware/EnsureSuperAdmin.php`

## 🎯 Bottom Navigation (Mobile)

Bottom navigation akan otomatis menyesuaikan berdasarkan role:

### Semua User (Authenticated)

-   **Home** → `/dashboard`
-   **Notifikasi** → `#` (belum diimplementasi)
-   **Profil** → `/profile`

### Kustomer & Mitra

-   Tambahan: **Bantuan** → `/helps`

## 📱 Cara Menggunakan

### Testing sebagai Kustomer:

```
1. Login dengan: budi@example.com / password
2. Akses: /dashboard
3. Klik "Buat Permintaan Bantuan" atau langsung ke /helps/create
4. Lihat bantuan Anda di /helps
```

### Testing sebagai Mitra:

```
1. Login dengan: ahmad@example.com / password
2. Akses: /dashboard
3. Klik "Lihat Bantuan Tersedia" atau langsung ke /helps/available
4. Ambil bantuan dengan klik tombol "Ambil Bantuan"
5. Lihat bantuan yang diambil di /helps
```

### Testing sebagai Admin:

```
1. Login dengan: admin.jakarta@mastulongmas.com / password
2. Akses: /dashboard
(Fitur admin masih dalam pengembangan)
```

### Testing sebagai Super Admin:

```
1. Login dengan: superadmin@mastulongmas.com / password
2. Akses: /dashboard
(Fitur super admin masih dalam pengembangan)
```

## 🔄 Flow Penggunaan Aplikasi

### Flow Kustomer (Yang Butuh Bantuan):

```
1. Register → Login
2. Dashboard (/dashboard)
3. Buat Permintaan (/helps/create)
4. Lihat Status (/helps)
5. Tunggu Mitra Mengambil
6. Hubungi Mitra
7. Beri Rating (setelah selesai)
```

### Flow Mitra (Relawan):

```
1. Register → Login
2. Dashboard (/dashboard)
3. Lihat Bantuan Tersedia (/ atau /helps/available)
4. Ambil Bantuan
5. Hubungi Kustomer
6. Bantu & Selesaikan
7. Tandai Selesai
```

## 🐛 Troubleshooting

### 403 Error:

-   Pastikan role user sesuai dengan middleware
-   Cek di database: `SELECT id, name, email, role FROM users;`

### 404 Not Found:

-   Jalankan: `php artisan route:list` untuk cek semua route
-   Pastikan route name sudah benar

### Layout Error:

-   Pastikan file `resources/views/layouts/app.blade.php` ada
-   Run: `npm run build` untuk compile assets

### Livewire Error:

-   Clear cache: `php artisan optimize:clear`
-   Pastikan Livewire component ada di `app/Livewire/`

## 📝 Command untuk Testing

```bash
# Lihat semua route
php artisan route:list

# Lihat route tertentu
php artisan route:list --name=helps

# Test route dengan curl
curl http://localhost:8000/

# Clear cache
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
```
