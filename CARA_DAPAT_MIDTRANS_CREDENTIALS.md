# 🔑 Cara Mendapatkan Midtrans Credentials

## Langkah-langkah:

### 1. Registrasi/Login ke Midtrans

**Untuk Testing (Sandbox):**
👉 https://dashboard.sandbox.midtrans.com/register

**Untuk Production:**
👉 https://dashboard.midtrans.com/register

### 2. Lengkapi Registrasi

-   Isi data bisnis/perusahaan Anda
-   Verifikasi email
-   Login ke dashboard

### 3. Dapatkan Access Keys

Setelah login:

1. Klik menu **Settings** (⚙️) di sidebar kiri
2. Pilih **Access Keys** atau **Configuration** → **Access Keys**
3. Anda akan melihat:
    - **Server Key** (untuk backend)
    - **Client Key** (untuk frontend)

### 4. Copy Credentials

**Sandbox (Testing):**

```
Server Key: Biasanya dimulai dengan "SB-Mid-server-"
Client Key: Biasanya dimulai dengan "SB-Mid-client-"
```

**Production:**

```
Server Key: Biasanya dimulai dengan "Mid-server-"
Client Key: Biasanya dimulai dengan "Mid-client-"
```

### 5. Update File .env

Buka file `.env` di project Anda dan update:

```env
# Untuk SANDBOX (Testing)
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false

# Untuk PRODUCTION
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=true
```

### 6. Clear Config Cache

Setelah update `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 📸 Screenshot Lokasi Access Keys

Di Midtrans Dashboard Sandbox:

```
Dashboard → Settings → Access Keys
```

Anda akan melihat halaman seperti ini:

```
┌─────────────────────────────────────────┐
│ Access Keys                             │
├─────────────────────────────────────────┤
│                                         │
│ Client Key                              │
│ [SB-Mid-client-xxxxxxxx] [Copy]        │
│                                         │
│ Server Key                              │
│ [•••••••••••••••••••••] [Show] [Copy]  │
│                                         │
└─────────────────────────────────────────┘
```

---

## ⚠️ Tips Keamanan

1. **JANGAN** commit Server Key ke Git/GitHub
2. **JANGAN** share Server Key di public
3. Server Key adalah **rahasia** - hanya untuk backend
4. Client Key **boleh** public - digunakan di frontend
5. Gunakan Sandbox untuk testing, Production untuk live

---

## 🧪 Testing Tanpa Registrasi (DEMO)

Jika Anda hanya ingin test cepat, bisa gunakan credential demo berikut:

**⚠️ HANYA UNTUK TESTING LOKAL - JANGAN UNTUK PRODUCTION!**

```env
# Demo Sandbox Credentials (Midtrans Documentation Sample)
MIDTRANS_SERVER_KEY=SB-Mid-server-abc123cde456
MIDTRANS_CLIENT_KEY=SB-Mid-client-abc123cde456
MIDTRANS_IS_PRODUCTION=false
```

**Catatan:** Credential demo mungkin tidak selalu bekerja. Lebih baik registrasi akun sendiri (gratis).

---

## 📞 Bantuan

Jika ada masalah:

-   **Midtrans Support:** support@midtrans.com
-   **Dokumentasi:** https://docs.midtrans.com/
-   **FAQ:** https://docs.midtrans.com/en/snap/faq

---

## ✅ Checklist

-   [ ] Registrasi di Midtrans Sandbox
-   [ ] Verifikasi email
-   [ ] Login ke dashboard
-   [ ] Copy Server Key
-   [ ] Copy Client Key
-   [ ] Update .env
-   [ ] Clear config cache
-   [ ] Test pembayaran

---

Setelah kredensial dikonfigurasi dengan benar, fitur top up akan berfungsi! 🎉
