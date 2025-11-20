# Fitur Top Up dengan Midtrans Payment Gateway

## Setup & Konfigurasi

### 1. Instalasi Package

Package Midtrans sudah terinstall via Composer:

```bash
composer require midtrans/midtrans-php
```

### 2. Konfigurasi Midtrans Credentials

Edit file `.env` dan tambahkan kredensial Midtrans Anda:

```env
MIDTRANS_SERVER_KEY=your-server-key-here
MIDTRANS_CLIENT_KEY=your-client-key-here
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**Cara mendapatkan Server Key & Client Key:**

1. Daftar/Login ke [Midtrans Dashboard](https://dashboard.midtrans.com/)
2. Pilih environment:
    - **Sandbox (Testing)**: https://dashboard.sandbox.midtrans.com/
    - **Production**: https://dashboard.midtrans.com/
3. Buka menu **Settings** → **Access Keys**
4. Copy **Server Key** dan **Client Key**
5. Paste ke file `.env`

**Catatan:**

-   Untuk testing, gunakan `MIDTRANS_IS_PRODUCTION=false` dan gunakan kredensial dari Sandbox
-   Untuk production, ubah menjadi `MIDTRANS_IS_PRODUCTION=true` dan gunakan kredensial dari Production

### 3. Jalankan Migration

```bash
php artisan migrate
```

Migration yang dibuat:

-   Menambahkan kolom `snap_token`, `payment_type`, `order_id`, dan `midtrans_response` ke tabel `balance_transactions`

---

## Cara Kerja Sistem

### Flow Pembayaran

1. **User mengisi form Top Up**

    - Pilih nominal (25k, 50k, 100k atau custom)
    - Pilih metode pembayaran (Bank Transfer atau E-Wallet)
    - Klik "Top Up Sekarang"

2. **Generate Snap Token**

    - Sistem membuat record transaksi baru dengan status `pending`
    - Sistem memanggil Midtrans API untuk mendapatkan Snap Token
    - Snap Token disimpan ke database

3. **Midtrans Snap Popup**

    - JavaScript membuka popup Midtrans Snap
    - User memilih metode pembayaran dan menyelesaikan transaksi
    - Midtrans mengirim notifikasi ke webhook

4. **Webhook Notification**
    - Midtrans mengirim POST request ke `/topup/notification`
    - Sistem mengupdate status transaksi
    - Jika sukses, saldo user otomatis bertambah

---

## Endpoint & Routes

### Customer Routes (Authenticated)

-   `GET /customer/top-up` - Halaman Top Up

### Midtrans Callback Routes (Public)

-   `GET /topup/finish` - Redirect setelah pembayaran selesai
-   `GET /topup/unfinish` - Redirect jika user membatalkan
-   `GET /topup/error` - Redirect jika terjadi error
-   `POST /topup/notification` - Webhook untuk notifikasi dari Midtrans

---

## Testing dengan Sandbox

### Kredensial Test

Midtrans Sandbox menyediakan kredensial test:

**Credit Card:**

-   Card Number: `4811 1111 1111 1114`
-   CVV: `123`
-   Exp Date: `01/25`
-   OTP: `112233`

**GoPay:**

-   Langsung approve di simulasi

**Bank Transfer:**

-   Gunakan virtual account yang digenerate
-   Approve di simulator Midtrans

### Simulator Midtrans

Akses simulator untuk approve pembayaran test:
https://simulator.sandbox.midtrans.com/

---

## Webhook Configuration

Untuk menerima notifikasi dari Midtrans, Anda perlu mengkonfigurasi webhook URL di Midtrans Dashboard.

### Setup Webhook URL

1. Login ke [Midtrans Dashboard](https://dashboard.sandbox.midtrans.com/)
2. Buka **Settings** → **Configuration**
3. Set **Payment Notification URL**:
    ```
    https://your-domain.com/topup/notification
    ```

**Untuk Development Lokal:**

Gunakan ngrok atau tool tunneling lainnya:

```bash
ngrok http 8000
```

Kemudian set webhook URL ke:

```
https://your-ngrok-url.ngrok.io/topup/notification
```

---

## Status Transaksi

### Status di Database

-   `pending` - Transaksi dibuat, menunggu pembayaran
-   `completed` - Pembayaran berhasil, saldo sudah ditambahkan
-   `failed` - Pembayaran gagal/dibatalkan

### Status dari Midtrans

-   `capture` - Kartu kredit berhasil di-charge
-   `settlement` - Pembayaran berhasil (bank transfer, e-wallet)
-   `pending` - Menunggu pembayaran
-   `deny` - Pembayaran ditolak
-   `cancel` - Pembayaran dibatalkan
-   `expire` - Pembayaran kadaluarsa

---

## Metode Pembayaran yang Tersedia

### Bank Transfer

-   BCA Virtual Account
-   BNI Virtual Account
-   BRI Virtual Account
-   Mandiri Bill Payment
-   Permata Virtual Account

### E-Wallet & QRIS

-   GoPay
-   ShopeePay
-   QRIS (untuk semua e-wallet)

---

## Files yang Dimodifikasi/Dibuat

### 1. Migration

-   `database/migrations/2025_11_19_add_midtrans_columns_to_balance_transactions.php`

### 2. Controller

-   `app/Http/Controllers/TopupController.php`

### 3. Livewire Component

-   `app/Livewire/Customer/Topup.php`

### 4. View

-   `resources/views/livewire/customer/topup.blade.php`

### 5. Config

-   `config/services.php` - Ditambahkan konfigurasi Midtrans
-   `.env` - Ditambahkan environment variables

### 6. Routes

-   `routes/web.php` - Ditambahkan routes untuk callback Midtrans

---

## Troubleshooting

### Error: "Server key not found"

**Solusi:** Pastikan `.env` sudah dikonfigurasi dengan benar dan jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### Error: "Snap token is missing"

**Solusi:** Periksa log Laravel di `storage/logs/laravel.log` untuk detail error dari Midtrans API

### Webhook tidak menerima notifikasi

**Solusi:**

1. Pastikan webhook URL sudah dikonfigurasi di Midtrans Dashboard
2. Pastikan URL accessible dari internet (gunakan ngrok untuk development)
3. Periksa log di `storage/logs/laravel.log`

### Saldo tidak bertambah setelah pembayaran

**Solusi:**

1. Cek tabel `balance_transactions` untuk status transaksi
2. Periksa kolom `midtrans_response` untuk detail dari Midtrans
3. Pastikan webhook URL bekerja dengan baik

---

## Security Notes

⚠️ **PENTING:**

1. **Jangan expose Server Key** - Simpan di `.env` dan jangan commit ke git
2. **Validasi Signature** - Midtrans mengirim signature untuk validasi notifikasi
3. **HTTPS Required** - Production harus menggunakan HTTPS
4. **Whitelist IP** - Consider whitelist Midtrans IP di production

---

## Support & Documentation

-   [Midtrans Snap Documentation](https://docs.midtrans.com/en/snap/overview)
-   [Midtrans API Reference](https://api-docs.midtrans.com/)
-   [Midtrans Dashboard](https://dashboard.midtrans.com/)
-   [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/)

---

## Contoh Penggunaan

### 1. User Top Up Rp 50.000

```
1. User mengisi form: amount = 50000, method = bank
2. Sistem generate order_id: TOPUP-1-1700450000
3. Sistem request Snap Token ke Midtrans
4. Snap popup terbuka, user pilih BCA Virtual Account
5. User transfer ke VA number yang diberikan
6. Midtrans kirim notifikasi ke webhook
7. Sistem update status menjadi 'completed'
8. Saldo user bertambah Rp 50.000
```

### 2. User Batalkan Pembayaran

```
1. User mengisi form dan klik Top Up
2. Snap popup terbuka
3. User menutup popup tanpa melakukan pembayaran
4. Status transaksi tetap 'pending' di database
5. User bisa melakukan top up baru
```

---

## Next Steps

1. ✅ Setup kredensial Midtrans di `.env`
2. ✅ Test di Sandbox environment
3. ✅ Configure webhook URL
4. ✅ Test full flow pembayaran
5. ⏳ Deploy ke production dengan kredensial production
6. ⏳ Monitor transaksi di Midtrans Dashboard

---

**Created:** November 19, 2025
**Version:** 1.0.0
