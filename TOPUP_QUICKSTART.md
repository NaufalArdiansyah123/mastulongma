# 🚀 Quick Start - Midtrans Top Up

## Setup Cepat

### 1. Konfigurasi `.env`

```env
MIDTRANS_SERVER_KEY=your-server-key-here
MIDTRANS_CLIENT_KEY=your-client-key-here
MIDTRANS_IS_PRODUCTION=false
```

Dapatkan key dari: https://dashboard.sandbox.midtrans.com/settings/config_info

### 2. Setup Webhook (untuk development)

```bash
# Install ngrok jika belum
ngrok http 8000
```

Kemudian:

1. Copy URL ngrok (misal: https://abc123.ngrok.io)
2. Buka https://dashboard.sandbox.midtrans.com/settings/configuration
3. Set **Payment Notification URL**: `https://abc123.ngrok.io/topup/notification`

### 3. Testing

1. Login sebagai customer
2. Buka `/customer/top-up`
3. Pilih nominal dan metode pembayaran
4. Klik "Top Up Sekarang"
5. Gunakan kredensial test:
    - **Credit Card**: `4811 1111 1111 1114`, CVV: `123`, Exp: `01/25`, OTP: `112233`
    - **Virtual Account**: Approve di https://simulator.sandbox.midtrans.com/

## File Penting

-   `app/Http/Controllers/TopupController.php` - Handle callback Midtrans
-   `app/Livewire/Customer/Topup.php` - Livewire component
-   `resources/views/livewire/customer/topup.blade.php` - UI
-   `routes/web.php` - Routes untuk webhook

## Routes

-   `GET /customer/top-up` - Halaman top up
-   `POST /topup/notification` - Webhook Midtrans
-   `GET /topup/finish` - Redirect setelah pembayaran
-   `GET /topup/unfinish` - Redirect jika dibatalkan
-   `GET /topup/error` - Redirect jika error

## Flow

1. User pilih nominal → Generate Snap Token
2. Popup Midtrans terbuka → User bayar
3. Midtrans kirim notifikasi → Webhook update status
4. Status = `completed` → Saldo otomatis bertambah

## Troubleshooting

**Webhook tidak menerima notifikasi?**

-   Pastikan ngrok running
-   Pastikan webhook URL sudah di-set di Midtrans Dashboard
-   Cek log: `storage/logs/laravel.log`

**Saldo tidak bertambah?**

-   Cek tabel `balance_transactions`, lihat kolom `status` dan `midtrans_response`
-   Pastikan webhook berhasil hit

## Dokumentasi Lengkap

Lihat: `TOPUP_MIDTRANS_SETUP.md`
