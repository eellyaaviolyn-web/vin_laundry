<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Pro - Manajemen Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f0f2f5;
        font-family: 'Poppins', 'Segoe UI', Roboto, sans-serif;
        overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
        background: linear-gradient(180deg, #1e2a3a 0%, #0f1724 100%);
        min-height: 100vh;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .sidebar .brand {
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .brand i {
        font-size: 2.5rem;
        color: #1abc9c;
    }

    .sidebar .brand h4 {
        color: white;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .sidebar .nav-link {
        color: #cbd5e1;
        padding: 0.8rem 1.5rem;
        margin: 0.3rem 0.8rem;
        border-radius: 12px;
        transition: 0.3s;
        font-weight: 500;
    }

    .sidebar .nav-link i {
        width: 28px;
        margin-right: 10px;
    }

    .sidebar .nav-link:hover {
        background: rgba(26, 188, 156, 0.2);
        color: white;
        transform: translateX(5px);
    }

    .sidebar .nav-link.active {
        background: linear-gradient(90deg, #1abc9c, #16a085);
        color: white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    /* Main content */
    .main-content {
        padding: 1.5rem;
    }

    /* Topbar */
    .topbar {
        background: white;
        border-radius: 20px;
        padding: 0.8rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-text h5 {
        margin: 0;
        font-weight: 600;
        color: #1e2a3a;
    }

    .welcome-text p {
        margin: 0;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .user-info {
        background: #f8f9fa;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        cursor: pointer;
    }

    .user-info i {
        font-size: 1.2rem;
        margin-right: 8px;
        color: #1abc9c;
    }

    /* Card style */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        color: white;
    }

    .btn-primary-custom:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 12px rgba(26, 188, 156, 0.3);
    }

    footer {
        text-align: center;
        margin-top: 2rem;
        padding: 1rem;
        color: #6c757d;
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        .sidebar {
            min-height: auto;
        }

        .main-content {
            margin-left: 0;
        }
    }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="brand">
                    <i class="fas fa-tshirt"></i>
                    <h4>LaundryPro</h4>
                </div>
                <nav class="nav flex-column mt-3">
                    <a class="nav-link <?= ($_GET['page'] ?? 'dashboard') == 'dashboard' ? 'active' : '' ?>"
                        href="index.php?page=dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                    <a class="nav-link <?= ($_GET['page'] ?? '') == 'outlets' ? 'active' : '' ?>"
                        href="index.php?page=outlets">
                        <i class="fas fa-store"></i> Outlet
                    </a>
                    <a class="nav-link <?= ($_GET['page'] ?? '') == 'users' ? 'active' : '' ?>"
                        href="index.php?page=users">
                        <i class="fas fa-users"></i> User
                    </a>
                    <?php endif; ?>
                    <a class="nav-link <?= ($_GET['page'] ?? '') == 'members' ? 'active' : '' ?>"
                        href="index.php?page=members">
                        <i class="fas fa-user-friends"></i> Member
                    </a>
                    <!-- Menu LAPORAN DIHAPUS -->
                    <a class="nav-link" href="index.php?page=logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="topbar">
                    <div class="welcome-text">
                        <h5><i class="fas fa-home me-2 text-primary"></i>Dashboard</h5>
                        <p>Selamat kelola laundry anda dengan mudah</p>
                    </div>
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
                        <span class="badge bg-success ms-2"><?= $_SESSION['user_role'] ?></span>
                    </div>
                </div>