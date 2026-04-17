<?php
// Ambil data statistik dari database
use LaundryApp\Config\Database;
$db = Database::getInstance()->getConnection();

// Hitung jumlah outlet
$stmt = $db->query("SELECT COUNT(*) as total FROM outlet");
$totalOutlet = $stmt->fetch()['total'];

// Hitung jumlah member
$stmt = $db->query("SELECT COUNT(*) as total FROM member");
$totalMember = $stmt->fetch()['total'];

// Hitung jumlah user
$stmt = $db->query("SELECT COUNT(*) as total FROM user");
$totalUser = $stmt->fetch()['total'];
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon me-3">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1">Total Outlet</h6>
                <h2 class="mb-0"><?= $totalOutlet ?></h2>
                <small class="text-success"><i class="fas fa-arrow-up"></i> aktif</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1">Total Member</h6>
                <h2 class="mb-0"><?= $totalMember ?></h2>
                <small class="text-info"><i class="fas fa-user-plus"></i> pelanggan terdaftar</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, #e67e22, #d35400);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1">Total Pengguna</h6>
                <h2 class="mb-0"><?= $totalUser ?></h2>
                <small class="text-warning"><i class="fas fa-user-check"></i> admin, kasir, owner</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-3">
                <h5><i class="fas fa-bolt me-2 text-warning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=members&action=create" class="btn btn-primary-custom">
                        <i class="fas fa-user-plus"></i> Registrasi Member Baru
                    </a>
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                    <a href="index.php?page=outlets&action=create" class="btn btn-outline-success">
                        <i class="fas fa-plus-circle"></i> Tambah Outlet
                    </a>
                    <a href="index.php?page=users&action=create" class="btn btn-outline-primary">
                        <i class="fas fa-user-shield"></i> Tambah Pengguna
                    </a>
                    <?php endif; ?>
                    <a href="index.php?page=reports" class="btn btn-outline-info">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-3">
                <h5><i class="fas fa-history me-2"></i> Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <?php
                $stmt = $db->prepare("SELECT l.*, u.name as user_name FROM logs l LEFT JOIN user u ON l.user_id = u.id ORDER BY l.id DESC LIMIT 5");
                $stmt->execute();
                $logs = $stmt->fetchAll();
                ?>
                <?php if(count($logs) > 0): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach($logs as $log): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-circle me-2 text-primary"></i>
                            <strong><?= htmlspecialchars($log['user_name'] ?? 'System') ?></strong>
                            <span class="badge bg-secondary ms-2"><?= $log['action'] ?></span>
                            <p class="small text-muted mt-1 mb-0"><?= htmlspecialchars($log['description']) ?></p>
                        </div>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></small>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-muted">Belum ada aktivitas tercatat.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>