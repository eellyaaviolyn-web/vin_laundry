# VIN Laundry - InfinityFree Setup Guide

## 🎯 Status Saat Ini

- ✅ Files sudah upload
- ✅ config/database.php sudah update dengan credentials InfinityFree
- ⏳ Database tables perlu di-import

## 📋 LANGKAH SETUP INFINITYFREE

### STEP 1: Verifikasi Database Credentials

**Credentials yang digunakan:**
```
Host: sql212.infinityfree.com
Database: if0_41185945_laundry
User: if0_41185945
Password: ReLCJyuWPIVec
```

Credentials ini sudah ada di `config/database.php`

### STEP 2: Import Database Tables

**Cara 1: Via phpMyAdmin (RECOMMENDED)**

1. Buka cPanel InfinityFree
2. Pilih **phpMyAdmin**
3. Login dengan credentials di atas
4. Select database: **if0_41185945_laundry**
5. Tab **Import**
6. Upload file **database.sql** dari project
7. Klik **Go** untuk execute

**Cara 2: Via SSH (Jika tersedia)**

```bash
mysql -h sql212.infinityfree.com -u if0_41185945 -pReLCJyuWPIVec if0_41185945_laundry < database.sql
```

### STEP 3: Verify Database Tables

Di phpMyAdmin, pastikan table berikut exist:
- ✅ `outlet`
- ✅ `user`
- ✅ `member`
- ✅ `logs`

### STEP 4: Verify Test Users

Di phpMyAdmin → Table `user`, pastikan ada:

| Email | Password | Role |
|-------|----------|------|
| admin@laundry.local | admin123 | admin |
| operator1@laundry.local | operator123 | operator |
| admin@admin | admin | admin |

### STEP 5: Test Koneksi

Buka: https://laundry-vynzkie.gamer.gd/vin_laundry/test.php

Harusnya menampilkan:
- ✓ File Structure: All OK
- ✓ Database Connection: OK
- ✓ Database Tables: All exist
- ✓ Users: 5 users found

### STEP 6: Login

Buka: https://laundry-vynzkie.gamer.gd/vin_laundry/

Gunakan credentials:
```
Email: admin@laundry.local
Password: admin123
```

## 🔧 Jika Masih Error

### Error: "No such file or directory"
- Database file tidak ditemukan
- Solusi: Pastikan database sudah dibuat dan credentials benar

### Error: "Access denied"
- Username/password salah
- Solusi: Double-check credentials di cPanel

### Error: "Unknown database"
- Database name salah
- Solusi: Pastikan exact name: `if0_41185945_laundry`

## 📱 Useful Tools

### System Test
```
https://laundry-vynzkie.gamer.gd/vin_laundry/test.php
```
Shows: File structure, DB connection, Tables, Users

### Debug Logger
```
https://laundry-vynzkie.gamer.gd/vin_laundry/debug.php
```
Shows: Error logs, Login attempts

### Database Credentials
File: `config/database.php`

```php
$host = 'sql212.infinityfree.com';
$dbname = 'if0_41185945_laundry';
$user = 'if0_41185945';
$pass = 'ReLCJyuWPIVec';
```

## ⚠️ SECURITY NOTES

**Development Mode** - Credentials visible untuk debugging
- Debug mode enabled
- Plain text passwords in database
- Test users exist

**Untuk Production:**
- [ ] Disable debug mode (`$debug_mode = false`)
- [ ] Hash semua passwords
- [ ] Change database credentials
- [ ] Move credentials ke environment variables
- [ ] Remove test users

## 📞 Troubleshooting Steps

1. **Check test.php output** - Lihat mana yang error
2. **Verify phpMyAdmin access** - Buka database dan check tables
3. **Check file permissions** - Pastikan files readable (644) dan folders executable (755)
4. **Check .htaccess** - Pastikan rewrite rules correct

## 🚀 Next Steps

- [ ] Import database.sql via phpMyAdmin
- [ ] Run test.php
- [ ] Login with test account
- [ ] Create new outlets
- [ ] Create new users
- [ ] Test member CRUD
- [ ] Prepare for production

---

**Setup Date:** 17 April 2026
**Server:** InfinityFree
**PHP Version:** Check via test.php
**Database:** MySQL/MariaDB
