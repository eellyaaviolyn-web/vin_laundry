# VIN Laundry - Troubleshooting Guide

## Masalah: ERR_EMPTY_RESPONSE

Error ini muncul ketika server mengirim response kosong. Kemungkinan penyebab:

### ✅ LANGKAH DIAGNOSIS

1. **Buka System Test Page** (PALING PENTING)
   ```
   https://laundry-vynzkie.gamer.gd/vin_laundry/test.php
   ```
   Halaman ini akan menampilkan:
   - Status file structure
   - Database connection test
   - Tables verification
   - Users list

2. **Jika test.php ERROR atau blank:**
   - Ini berarti file PHP tidak ter-execute di server
   - Kemungkinan: PHP tidak enabled, folder tidak accessible
   - Contact hosting support

3. **Jika test.php OK tapi login masih error:**
   Kemungkinan masalah:
   - Database tidak connect
   - View files (login.php) tidak ditemukan
   - Cek output di test.php untuk detail error

### 🔧 COMMON FIXES

**Problem 1: "Database Connection Error"**
- [ ] Pastikan MySQL/MariaDB running di server
- [ ] Jalankan `database.sql` di phpMyAdmin
- [ ] Cek username/password di `config/database.php`
- [ ] Cek database name = `laundry_db`

**Problem 2: "View file not found: views/auth/login.php"**
- [ ] Pastikan folder structure benar:
  ```
  vin_laundry/
  ├── views/
  │   └── auth/
  │       └── login.php
  ├── config/
  │   └── database.php
  └── index.php
  ```
- [ ] Upload semua file dengan benar
- [ ] Check file permissions (644 untuk files, 755 untuk folders)

**Problem 3: Login gagal padahal user ada**
- [ ] Buka debug.php untuk lihat detailed login logs
- [ ] Cek password di database dengan test.php
- [ ] Gunakan test accounts dari database.sql:
  - admin@laundry.local : admin123
  - operator1@laundry.local : operator123

### 📋 TEST ACCOUNTS

```
Email                    | Password      | Role
-------------------------|---------------|----------
admin@laundry.local      | admin123      | admin
operator1@laundry.local  | operator123   | operator
operator2@laundry.local  | operator123   | operator
manager1@laundry.local   | manager123    | manager
admin@admin              | admin         | admin
```

### 🌐 URLS PENTING

- Login: `https://laundry-vynzkie.gamer.gd/vin_laundry/index.php?page=login`
- System Test: `https://laundry-vynzkie.gamer.gd/vin_laundry/test.php`
- Debug Logger: `https://laundry-vynzkie.gamer.gd/vin_laundry/debug.php`

### 📞 TECHNICAL DETAILS

**File penting:**
- `index.php` - Entry point
- `config/database.php` - Database config
- `Models/Auth.php` - Login logic
- `views/auth/login.php` - Login form
- `test.php` - System diagnostics

**Debug mode enabled:**
- Login akan log detail debug info
- Error messages lebih jelas
- Disable di production dengan mengubah `$debug_mode = false` di index.php

### ⚠️ NEXT STEPS

1. Akses `test.php` dan lihat hasilnya
2. Screenshoot hasil test dan share
3. Jika ada error, ikuti instruksi error message
4. Cek database via phpMyAdmin jika database error

---

**Update terakhir:** 17 April 2026
**Version:** 1.0 Development
