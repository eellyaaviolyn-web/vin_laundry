<?php
ob_start();
echo "<!-- System starting -->\n";
session_start();

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("[$errno] $errstr in $errfile:$errline");
    ob_end_clean();
    ?>
    <!DOCTYPE html><html><head><meta charset="UTF-8"><title>Error</title></head>
    <body style="font-family:Arial;padding:20px;background:#f5f5f5"><div style="background:white;padding:20px;border-radius:5px;max-width:500px;margin:50px auto"><h3 style="color:#d32f2f">⚠️ Kesalahan Sistem</h3><p style="color:#666">Terjadi kesalahan pada sistem aplikasi.</p><p style="font-size:0.9em;color:#999">Error [<?= $errno ?>]: <?= htmlspecialchars($errstr) ?></p><p style="font-size:0.85em;color:#999">File: <?= htmlspecialchars($errfile) ?>:<?= $errline ?></p><a href="index.php?page=login" style="color:#1976d2;text-decoration:none">← Kembali ke Login</a></div></body></html>
    <?php
    exit;
}, E_ALL);

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        ob_end_clean();
        ?>
        <!DOCTYPE html><html><head><meta charset="UTF-8"><title>Fatal Error</title></head>
        <body style="font-family:Arial;padding:20px;background:#f5f5f5"><div style="background:white;padding:20px;border-radius:5px;max-width:500px;margin:50px auto"><h3 style="color:#d32f2f">🔴 Fatal Error</h3><p style="color:#666">Terjadi kesalahan fatal.</p><p style="font-size:0.9em;color:#999"><?= htmlspecialchars($error['message']) ?></p><p style="font-size:0.85em;color:#999">File: <?= htmlspecialchars($error['file']) ?>:<?= $error['line'] ?></p><a href="index.php?page=login" style="color:#1976d2;text-decoration:none">← Kembali ke Login</a></div></body></html>
        <?php
    }
});

spl_autoload_register(function($class) {
    $prefix = 'LaundryApp\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $path_parts = explode('\\', $relative_class);
    $attempts = [];
    $a1 = $path_parts; for ($i = 0; $i < count($a1) - 1; $i++) $a1[$i] = strtolower($a1[$i]);
    $attempts[] = $base_dir . implode('/', $a1) . '.php';
    $attempts[] = $base_dir . implode('/', $path_parts) . '.php';
    $a3 = $path_parts; for ($i = 0; $i < count($a3) - 1; $i++) $a3[$i] = ucfirst(strtolower($a3[$i]));
    $attempts[] = $base_dir . implode('/', $a3) . '.php';
    $found_file = null;
    foreach ($attempts as $file) { if (file_exists($file)) { $found_file = $file; break; } }
    if (!$found_file) {
        foreach ($attempts as $file) {
            $dir = dirname($file); $filename = basename($file);
            if (is_dir($dir)) { $files = scandir($dir); foreach ($files as $f) { if (strtolower($f) === strtolower($filename)) { $found_file = $dir . '/' . $f; break 2; } } }
        }
    }
    if ($found_file && file_exists($found_file)) { require $found_file; } 
    else { throw new \Exception("Class file not found: $class"); }
});

use LaundryApp\Models\Auth;
use LaundryApp\Models\Outlet;
use LaundryApp\Models\UserModel;
use LaundryApp\Models\Member;
use LaundryApp\Models\Paket;
use LaundryApp\Models\Transaksi;

 $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'login';
 $action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';

try { $db_test = \LaundryApp\Config\Database::getInstance()->getConnection(); } 
catch (Exception $e) { ob_end_clean(); die("<h3>❌ DB Error</h3><p>".$e->getMessage()."</p>"); }

if($page == 'login') {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        try {
            $auth = new Auth();
            if($auth->login($_POST['email'], $_POST['password'])) { header('Location: index.php?page=dashboard'); exit; }
            else { $error = "Email atau password salah!"; }
        } catch (Exception $e) { $error = "Error: " . $e->getMessage(); }
    }
    include 'views/auth/login.php';
}
elseif($page == 'register') {
    try {
        $outletModel = new Outlet(); $outlets = $outletModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
            $auth = new Auth();
            if($_POST['password'] == $_POST['confirm_password']) {
                if($auth->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['outlet_id'])) { header('Location: index.php?page=login&registered=1'); exit; }
                else $error = "Email sudah terdaftar!";
            } else $error = "Password tidak cocok!";
        }
    } catch (Exception $e) { $error = "Error: " . $e->getMessage(); }
    include 'views/auth/register.php';
}
elseif($page == 'logout') {
    $auth = new Auth(); $auth->logout(); header('Location: index.php?page=login'); exit;
}
elseif($page == 'dashboard') {
    if(!isset($_SESSION['user_id'])) { header('Location: index.php?page=login'); exit; }
    include 'views/dashboard.php';
}

// ==================== OUTLET CRUD ====================
elseif($page == 'outlets') {
    try {
        Auth::checkRole(['admin']);
        $outletModel = new Outlet();
        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($outletModel->create($_POST['name'], $_POST['address'], $_POST['phone'])) $_SESSION['success'] = "Outlet berhasil ditambahkan!";
                else $_SESSION['error'] = "Gagal menambahkan outlet!";
                header('Location: index.php?page=outlets'); exit;
            }
            include 'views/outlets/form.php'; exit;
        }
        if($action == 'edit' && isset($_GET['id'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($outletModel->update($_GET['id'], $_POST['name'], $_POST['address'], $_POST['phone'])) $_SESSION['success'] = "Outlet berhasil diupdate!";
                else $_SESSION['error'] = "Gagal update outlet!";
                header('Location: index.php?page=outlets'); exit;
            }
            $data = $outletModel->find($_GET['id']);
            if(!$data) { $_SESSION['error'] = "Outlet tidak ditemukan!"; header('Location: index.php?page=outlets'); exit; }
            include 'views/outlets/form.php'; exit;
        }
        if($action == 'delete' && isset($_GET['id'])) {
            if($outletModel->delete($_GET['id'])) $_SESSION['success'] = "Outlet berhasil dihapus!";
            else $_SESSION['error'] = "Gagal hapus outlet!";
            header('Location: index.php?page=outlets'); exit;
        }
        $outlets = $outletModel->getAll(); include 'views/outlets/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}

// ==================== USER CRUD ====================
elseif($page == 'users') {
    try {
        Auth::checkRole(['admin']);
        $userModel = new UserModel(); $outletModel = new Outlet(); $outlets = $outletModel->getAll();
        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($userModel->create($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['outlet_id'])) $_SESSION['success'] = "User berhasil ditambahkan!";
                else $_SESSION['error'] = "Gagal menambahkan user!";
                header('Location: index.php?page=users'); exit;
            }
            include 'views/users/form.php'; exit;
        }
        if($action == 'edit' && isset($_GET['id'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = !empty($_POST['password']) ? $_POST['password'] : null;
                if($userModel->update($_GET['id'], $_POST['name'], $_POST['email'], $_POST['role'], $_POST['outlet_id'], $password)) $_SESSION['success'] = "User berhasil diupdate!";
                else $_SESSION['error'] = "Gagal update user!";
                header('Location: index.php?page=users'); exit;
            }
            $data = $userModel->find($_GET['id']);
            if(!$data) { $_SESSION['error'] = "User tidak ditemukan!"; header('Location: index.php?page=users'); exit; }
            include 'views/users/form.php'; exit;
        }
        if($action == 'delete' && isset($_GET['id'])) {
            if($userModel->delete($_GET['id'])) $_SESSION['success'] = "User berhasil dihapus!";
            else $_SESSION['error'] = "Gagal hapus user!";
            header('Location: index.php?page=users'); exit;
        }
        $users = $userModel->getAll(); include 'views/users/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}

// ==================== MEMBER CRUD ====================
elseif($page == 'members') {
    try {
        Auth::checkRole(['admin','kasir']);
        $memberModel = new Member();
        
        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($_SESSION['user_role'] == 'kasir') $_POST['outlet_id'] = $_SESSION['outlet_id']; // KEAMANAN KASIR
                if($memberModel->create($_POST['nama'], $_POST['telp'], $_POST['alamat'], $_POST['jenis_kelamin'], $_POST['outlet_id'])) $_SESSION['success'] = "Member berhasil ditambahkan!";
                else $_SESSION['error'] = "Gagal menambahkan member!";
                header('Location: index.php?page=members'); exit;
            }
            include 'views/members/form.php'; exit;
        }
        if($action == 'edit' && isset($_GET['id'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($_SESSION['user_role'] == 'kasir') $_POST['outlet_id'] = $_SESSION['outlet_id']; // KEAMANAN KASIR
                if($memberModel->update($_GET['id'], $_POST['nama'], $_POST['telp'], $_POST['alamat'], $_POST['jenis_kelamin'], $_POST['outlet_id'])) $_SESSION['success'] = "Member berhasil diupdate!";
                else $_SESSION['error'] = "Gagal update member!";
                header('Location: index.php?page=members'); exit;
            }
            $data = $memberModel->find($_GET['id']);
            if(!$data) { $_SESSION['error'] = "Member tidak ditemukan!"; header('Location: index.php?page=members'); exit; }
            include 'views/members/form.php'; exit;
        }
        if($action == 'delete' && isset($_GET['id'])) {
            try {
                if($memberModel->delete($_GET['id'])) $_SESSION['success'] = "Member berhasil dihapus!";
                else $_SESSION['error'] = "Gagal hapus member!";
            } catch (\PDOException $e) {
                $_SESSION['error'] = ($e->getCode() == 23000) ? "Gagal menghapus! Member ini sudah memiliki riwayat transaksi." : "Gagal menghapus member.";
            }
            header('Location: index.php?page=members'); exit;
        }
        
        if($_SESSION['user_role'] == 'kasir') $members = $memberModel->getAll($_SESSION['outlet_id']);
        else $members = $memberModel->getAll(null);
        
        include 'views/members/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}

// ==================== PAKET CRUD ====================
elseif($page == 'paket') {
    try {
        Auth::checkRole(['admin', 'kasir']);
        $paketModel = new Paket(); $outletModel = new Outlet(); $outlets = $outletModel->getAll();
        
        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($_SESSION['user_role'] == 'kasir') $_POST['outlet_id'] = $_SESSION['outlet_id']; // KEAMANAN KASIR
                if($paketModel->create($_POST['name'], $_POST['price'], $_POST['unit'], $_POST['description'], $_POST['outlet_id'])) $_SESSION['success'] = "Paket berhasil ditambahkan!";
                else $_SESSION['error'] = "Gagal menambahkan paket!";
                header('Location: index.php?page=paket'); exit;
            }
            include 'views/paket/form.php'; exit;
        }
        if($action == 'edit' && isset($_GET['id'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($_SESSION['user_role'] == 'kasir') $_POST['outlet_id'] = $_SESSION['outlet_id']; // KEAMANAN KASIR
                if($paketModel->update($_GET['id'], $_POST['name'], $_POST['price'], $_POST['unit'], $_POST['description'], $_POST['outlet_id'])) $_SESSION['success'] = "Paket berhasil diupdate!";
                else $_SESSION['error'] = "Gagal update paket!";
                header('Location: index.php?page=paket'); exit;
            }
            $data = $paketModel->find($_GET['id']);
            if(!$data) { $_SESSION['error'] = "Paket tidak ditemukan!"; header('Location: index.php?page=paket'); exit; }
            include 'views/paket/form.php'; exit;
        }
        if($action == 'delete' && isset($_GET['id'])) {
            if($paketModel->delete($_GET['id'])) $_SESSION['success'] = "Paket berhasil dihapus!";
            else $_SESSION['error'] = "Gagal hapus paket!";
            header('Location: index.php?page=paket'); exit;
        }
        
        if($_SESSION['user_role'] == 'kasir') $pakets = $paketModel->getAll($_SESSION['outlet_id']);
        else $pakets = $paketModel->getAll(null);
        
        include 'views/paket/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}

// ==================== TRANSAKSI CRUD ====================
elseif($page == 'transaksi') {
    try {
        Auth::checkRole(['admin', 'kasir']);
        $transaksiModel = new Transaksi(); $memberModel = new Member(); $paketModel = new Paket();
        $outlet_id = $_SESSION['outlet_id'] ?? null;
        
        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                try {
                    $invoice = $transaksiModel->create($_POST);
                    $_SESSION['success'] = "Transaksi $invoice berhasil disimpan!";
                } catch (\Exception $e) { $_SESSION['error'] = $e->getMessage(); }
                header('Location: index.php?page=transaksi'); exit;
            }
            if($_SESSION['user_role'] == 'kasir') { $members = $memberModel->getAll($outlet_id); $pakets = $paketModel->getAll($outlet_id); }
            else { $members = $memberModel->getAll(null); $pakets = $paketModel->getAll(null); }
            $tx_data = null; include 'views/transaksi/form.php'; exit;
        }
        if($action == 'edit' && isset($_GET['id'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                try { $transaksiModel->update($_GET['id'], $_POST); $_SESSION['success'] = "Transaksi berhasil diupdate!"; }
                catch (\Exception $e) { $_SESSION['error'] = $e->getMessage(); }
                header('Location: index.php?page=transaksi'); exit;
            }
            $tx_data = $transaksiModel->findWithDetails($_GET['id']);
            if(!$tx_data) { $_SESSION['error'] = "Transaksi tidak ditemukan!"; header('Location: index.php?page=transaksi'); exit; }
            if($_SESSION['user_role'] == 'kasir') { $members = $memberModel->getAll($outlet_id); $pakets = $paketModel->getAll($outlet_id); }
            else { $members = $memberModel->getAll(null); $pakets = $paketModel->getAll(null); }
            include 'views/transaksi/form.php'; exit;
        }
        if($action == 'delete' && isset($_GET['id'])) {
            if($transaksiModel->delete($_GET['id'])) $_SESSION['success'] = "Transaksi berhasil dihapus!";
            else $_SESSION['error'] = "Gagal menghapus transaksi!";
            header('Location: index.php?page=transaksi'); exit;
        }
        if($action == 'print' && isset($_GET['id'])) {
            $print_data = $transaksiModel->findWithDetails($_GET['id']);
            if(!$print_data) { $_SESSION['error'] = "Transaksi tidak ditemukan!"; header('Location: index.php?page=transaksi'); exit; }
            ob_end_clean(); include 'views/transaksi/print.php'; exit;
        }
        if($action == 'status' && isset($_GET['id'])) {
            $transaksiModel->updateStatus($_GET['id'], $_GET['status'], $_GET['payment'] ?? null);
            header('Location: index.php?page=transaksi'); exit;
        }
        
        $transaksis = $transaksiModel->getAll($outlet_id);
        include 'views/transaksi/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}

// ==================== LAPORAN ====================
elseif($page == 'laporan') {
    try {
        Auth::checkRole(['admin', 'owner', 'kasir']);
        $db = \LaundryApp\Config\Database::getInstance()->getConnection();
        
         $start_date       = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
 $end_date         = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
        
        $outletFilter = '';
        $params = [$start_date, $end_date];
        if ($_SESSION['user_role'] == 'kasir') {
            $outletFilter = ' AND t.outlet_id = ?';
            $params[] = $_SESSION['outlet_id'];
        }
        
        $sql = "SELECT 
                    t.kode_invoice,
                    t.tanggal,
                    t.biaya_tambahan,
                    t.diskon,
                    t.status,
                    t.dibayar,
                    m.name AS member_name,
                    o.name AS outlet_name,
                    COALESCE(d.total_paket, 0) AS total_paket
                FROM transaksi t
                LEFT JOIN member m ON t.member_id = m.id
                LEFT JOIN outlet o ON t.outlet_id = o.id
                LEFT JOIN (
                    SELECT transaksi_id, SUM(subtotal) AS total_paket
                    FROM detail_transaksi
                    GROUP BY transaksi_id
                ) d ON t.id = d.transaksi_id
                WHERE t.tanggal BETWEEN ? AND ?
                $outletFilter
                ORDER BY t.tanggal DESC, t.id DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $laporan = $stmt->fetchAll();
        
        $sql_total = "SELECT COALESCE(SUM(
                    COALESCE(d.total_paket, 0) + COALESCE(t.biaya_tambahan, 0) - COALESCE(t.diskon, 0)
                ), 0) AS total
                FROM transaksi t
                LEFT JOIN (
                    SELECT transaksi_id, SUM(subtotal) AS total_paket
                    FROM detail_transaksi
                    GROUP BY transaksi_id
                ) d ON t.id = d.transaksi_id
                WHERE t.tanggal BETWEEN ? AND ?
                $outletFilter
                AND t.status = 'diambil'";
        
        $stmt_total = $db->prepare($sql_total);
        $stmt_total->execute($params);
        $total_pendapatan = (float) $stmt_total->fetchColumn();

        // ✅ CETAK LAPORAN
        if ($action == 'print') {
            ob_end_clean();
            include 'views/laporan/print.php';
            exit;
        }

        include 'views/laporan/index.php';
    } catch (Exception $e) { echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>"; }
}
else {
    http_response_code(404);
    echo "<div class='alert alert-danger'>Halaman tidak ditemukan: " . htmlspecialchars($page) . "</div>";
}

 $content = ob_get_clean();

if(!in_array($page, ['login','register'])) {
    if(file_exists('views/layouts/header.php')) include 'views/layouts/header.php';
    echo $content;
    if(file_exists('views/layouts/footer.php')) include 'views/layouts/footer.php';
} else {
    echo $content;
}

ob_end_flush();
?>