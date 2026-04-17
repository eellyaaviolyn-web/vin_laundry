<?php
session_start();
spl_autoload_register(function($class) {
    $prefix = 'LaundryApp\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

use LaundryApp\Models\Auth;
use LaundryApp\Models\Outlet;
use LaundryApp\Models\UserModel;
use LaundryApp\Models\Member;

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? '';

ob_start();

// LOGIN
if($page == 'login') {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $auth = new Auth();
        if($auth->login($_POST['email'], $_POST['password'])) {
            header('Location: index.php?page=dashboard');
            exit;
        } else $error = "Email atau password salah!";
    }
    include 'views/auth/login.php';
}
// REGISTER
elseif($page == 'register') {
    $outletModel = new Outlet();
    $outlets = $outletModel->getAll();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $auth = new Auth();
        if($_POST['password'] == $_POST['confirm_password']) {
            if($auth->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['outlet_id'])) {
                header('Location: index.php?page=login&registered=1');
                exit;
            } else $error = "Email sudah terdaftar!";
        } else $error = "Password tidak cocok!";
    }
    include 'views/auth/register.php';
}
// LOGOUT
elseif($page == 'logout') {
    $auth = new Auth();
    $auth->logout();
    header('Location: index.php?page=login');
    exit;
}
// DASHBOARD
elseif($page == 'dashboard') {
    if(!isset($_SESSION['user_id'])) { header('Location: index.php?page=login'); exit; }
    include 'views/dashboard.php';
}
// ==================== OUTLET CRUD ====================
elseif($page == 'outlets') {
    Auth::checkRole(['admin']);
    $outletModel = new Outlet();
    
    // CREATE
    if($action == 'create') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($outletModel->create($_POST['name'], $_POST['address'], $_POST['phone'])) {
                $_SESSION['success'] = "Outlet berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan outlet!";
            }
            header('Location: index.php?page=outlets');
            exit;
        }
        include 'views/outlets/form.php';
        exit;
    }
    
    // EDIT
    if($action == 'edit' && isset($_GET['id'])) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($outletModel->update($_GET['id'], $_POST['name'], $_POST['address'], $_POST['phone'])) {
                $_SESSION['success'] = "Outlet berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal update outlet!";
            }
            header('Location: index.php?page=outlets');
            exit;
        }
        $data = $outletModel->find($_GET['id']);
        if(!$data) {
            $_SESSION['error'] = "Outlet tidak ditemukan!";
            header('Location: index.php?page=outlets');
            exit;
        }
        include 'views/outlets/form.php';
        exit;
    }
    
    // DELETE
    if($action == 'delete' && isset($_GET['id'])) {
        if($outletModel->delete($_GET['id'])) {
            $_SESSION['success'] = "Outlet berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal hapus outlet (masih ada user terkait?)";
        }
        header('Location: index.php?page=outlets');
        exit;
    }
    
    // READ (list)
    $outlets = $outletModel->getAll();
    include 'views/outlets/index.php';
}
// ==================== USER CRUD ====================
elseif($page == 'users') {
    Auth::checkRole(['admin']);
    $userModel = new UserModel();
    $outletModel = new Outlet();
    $outlets = $outletModel->getAll();
    
    // CREATE
    if($action == 'create') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($userModel->create($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['outlet_id'])) {
                $_SESSION['success'] = "User berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan user!";
            }
            header('Location: index.php?page=users');
            exit;
        }
        include 'views/users/form.php';
        exit;
    }
    
    // EDIT
    if($action == 'edit' && isset($_GET['id'])) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            if($userModel->update($_GET['id'], $_POST['name'], $_POST['email'], $_POST['role'], $_POST['outlet_id'], $password)) {
                $_SESSION['success'] = "User berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal update user!";
            }
            header('Location: index.php?page=users');
            exit;
        }
        $data = $userModel->find($_GET['id']);
        if(!$data) {
            $_SESSION['error'] = "User tidak ditemukan!";
            header('Location: index.php?page=users');
            exit;
        }
        include 'views/users/form.php';
        exit;
    }
    
    // DELETE
    if($action == 'delete' && isset($_GET['id'])) {
        if($userModel->delete($_GET['id'])) {
            $_SESSION['success'] = "User berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal hapus user!";
        }
        header('Location: index.php?page=users');
        exit;
    }
    
    // READ (list)
    $users = $userModel->getAll();
    include 'views/users/index.php';
}
// ==================== MEMBER CRUD ====================
elseif($page == 'members') {
    Auth::checkRole(['admin','kasir','owner']);
    $memberModel = new Member();
    $outletModel = new Outlet();
    $outlets = $outletModel->getAll();
    
    // CREATE
    if($action == 'create') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($memberModel->create($_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['outlet_id'])) {
                $_SESSION['success'] = "Member berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan member!";
            }
            header('Location: index.php?page=members');
            exit;
        }
        include 'views/members/form.php';
        exit;
    }
    
    // EDIT
    if($action == 'edit' && isset($_GET['id'])) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($memberModel->update($_GET['id'], $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['outlet_id'])) {
                $_SESSION['success'] = "Member berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal update member!";
            }
            header('Location: index.php?page=members');
            exit;
        }
        $data = $memberModel->find($_GET['id']);
        if(!$data) {
            $_SESSION['error'] = "Member tidak ditemukan!";
            header('Location: index.php?page=members');
            exit;
        }
        include 'views/members/form.php';
        exit;
    }
    
    // DELETE
    if($action == 'delete' && isset($_GET['id'])) {
        if($memberModel->delete($_GET['id'])) {
            $_SESSION['success'] = "Member berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal hapus member!";
        }
        header('Location: index.php?page=members');
        exit;
    }
    
    // READ (list)
    $members = $memberModel->getAll($_SESSION['user_role'] == 'owner' || $_SESSION['user_role'] == 'kasir' ? $_SESSION['outlet_id'] : null);
    include 'views/members/index.php';
}
// ==================== LAPORAN ====================
// elseif($page == 'reports') {
//     Auth::checkRole(['admin','kasir','owner']);
//     $db = \LaundryApp\Config\Database::getInstance()->getConnection();
//     $outlet_id = ($_SESSION['user_role'] == 'owner' || $_SESSION['user_role'] == 'kasir') ? $_SESSION['outlet_id'] : null;
//     $stmt = $db->prepare("CALL GetMemberReport(?)");
//     $stmt->execute([$outlet_id]);
//     $reports = $stmt->fetchAll();
//     include 'views/reports/index.php';
// }
else {
    echo "<div class='alert alert-danger'>Halaman tidak ditemukan</div>";
}

$content = ob_get_clean();
if(!in_array($page, ['login','register'])) {
    include 'views/layouts/header.php';
    echo $content;
    include 'views/layouts/footer.php';
} else {
    echo $content;
}