# Case Sensitivity Issue - SOLVED

## Problem
```
Class file not found: LaundryApp\Models\Auth
```

## Root Cause
Linux/InfinityFree server **case-sensitive** untuk file names:
- `Auth.php` ≠ `auth.php`
- `Models/` ≠ `models/` (tergantung bagaimana upload)

## Solution Applied

### 1. Improved Autoloader
Autoloader sekarang try multiple path variations:
- ✅ Lowercase folders: `models/Auth.php`
- ✅ Original case: `Models/Auth.php`  
- ✅ Capital first: `Models/Auth.php`
- ✅ Directory scan dengan case-insensitive matching

### 2. File Structure
Pastikan ini exact:
```
vin_laundry/
├── config/
│   └── database.php
├── Models/           ← CAPITAL M
│   ├── Auth.php      ← CAPITAL A
│   ├── Member.php    ← CAPITAL M
│   ├── Outlet.php    ← CAPITAL O
│   ├── UserModel.php
│   └── auth.php      ← (lowercase, dapat dihapus)
├── helpers/
│   └── Logger.php
├── views/
│   ├── auth/
│   ├── layouts/
│   └── ...
├── index.php
└── test.php
```

## Upload Instructions

Saat upload ke InfinityFree:

1. **Check folder names di cPanel File Manager:**
   - `Models` (capital M) ← Check ini!
   - Bukan `models` (lowercase)

2. **Upload file dengan case benar:**
   - `Auth.php` (capital A)
   - Bukan `auth.php`

3. **Delete duplikat:**
   - Jika ada `auth.php` (lowercase), delete
   - Keep hanya `Auth.php` (capital A)

## Test Autoloader

Buka: `https://laundry-vynzkie.gamer.gd/vin_laundry/test.php`

Cek folder structure section:
```
✓ config/
✓ Models/    ← Must have capital M
✗ models/    ← Should NOT exist
✓ helpers/
✓ views/
```

## If Still Error

1. Via cPanel File Manager:
   - Delete folder `models/` jika ada (lowercase)
   - Rename `models` to `Models` jika needed
   - Check file `Models/Auth.php` exists

2. Re-upload files:
   - Create folder `Models/` (capital)
   - Upload `Auth.php`, `Member.php`, `Outlet.php`, `UserModel.php`

3. Test lagi dengan `test.php`

## Technical Details

**Why Case Matters:**
- Windows/localhost: case-insensitive (file.php = FILE.PHP)
- Linux/InfinityFree: case-sensitive (file.php ≠ FILE.PHP)

**Current Autoloader:**
```php
// Try multiple attempts
$attempts = [
    'models/Auth.php',      // Attempt 1: lowercase
    'Models/Auth.php',      // Attempt 2: original
    'Models/Auth.php',      // Attempt 3: capital first
];
// Then directory scan if all failed
```

---

**Status:** ✅ Autoloader improved to handle case variations
**Next:** Verify folder structure via cPanel File Manager
