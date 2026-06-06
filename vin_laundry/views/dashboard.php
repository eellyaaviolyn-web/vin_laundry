<?php
use LaundryApp\Config\Database;

 $db = Database::getInstance()->getConnection();
 $role = $_SESSION['user_role'] ?? '';
 $outlet_id = $_SESSION['outlet_id'] ?? null;

// Khusus Admin & Owner: Lihat semua data global
if ($role == 'admin' || $role == 'owner') {
    $totalOutlets = $db->query("SELECT COUNT(*) FROM outlet")->fetchColumn();
    $totalMembers = $db->query("SELECT COUNT(*) FROM member")->fetchColumn();
    $totalUsers = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
} 
// Khusus Kasir: Hanya lihat data outletnya sendiri
else {
    $stmtM = $db->prepare("SELECT COUNT(*) FROM member WHERE outlet_id = ?");
    $stmtM->execute([$outlet_id]);
    $totalMembers = $stmtM->fetchColumn();
    $totalOutlets = '-';
    $totalUsers = '-';
}

// Query Pendapatan & Transaksi (Sudah aman, otomatis filter berdasarkan role)
if ($role == 'kasir') {
    $filterOutlet = " AND outlet_id = '$outlet_id'";
} else {
    $filterOutlet = "";
}

 $today = date('Y-m-d');
 $bulanIni = date('Y-m-01');

 $stmtHarian = $db->query("SELECT COALESCE(SUM(total_biaya), 0) FROM transaksi WHERE DATE(tanggal) = '$today' $filterOutlet");
 $pendapatanHariIni = $stmtHarian->fetchColumn();

 $stmtBulanan = $db->query("SELECT COALESCE(SUM(total_biaya), 0) FROM transaksi WHERE DATE(tanggal) >= '$bulanIni' $filterOutlet");
 $pendapatanBulanIni = $stmtBulanan->fetchColumn();

 $stmtTxHarian = $db->query("SELECT COUNT(*) FROM transaksi WHERE DATE(tanggal) = '$today' $filterOutlet");
 $transaksiHariIni = $stmtTxHarian->fetchColumn();

 $stmtTxProses = $db->query("SELECT COUNT(*) FROM transaksi WHERE (status = 'proses' OR status = 'baru') $filterOutlet");
 $transaksiProses = $stmtTxProses->fetchColumn();

// Log aktivitas
try {
    $stmtLog = $db->query("SELECT l.*, u.name as user_name FROM activity_log l JOIN user u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT 5");
    $logs = $stmtLog ? $stmtLog->fetchAll() : [];
} catch (\Exception $e) {
    $logs = []; 
}
?>

<div class="row g-4 mb-4">
    <?php if($role == 'admin' || $role == 'owner'): ?>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">Pendapatan Hari Ini</p>
                    <h4 class="mb-0 text-success fw-bold">Rp <?= number_format($pendapatanHariIni, 0, ',', '.') ?></h4>
                </div>
                <div class="stat-icon bg-success"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">Pendapatan Bulan Ini</p>
                    <h4 class="mb-0 text-primary fw-bold">Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></h4>
                </div>
                <div class="stat-icon bg-primary"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Tampilan Khusus Kasir (Lebih Sederhana) -->
    <div class="col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">Total Pendapatan Hari Ini</p>
                    <h4 class="mb-0 text-success fw-bold">Rp <?= number_format($pendapatanHariIni, 0, ',', '.') ?></h4>
                </div>
                <div class="stat-icon bg-success"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">Transaksi Hari Ini</p>
                    <h4 class="mb-0 fw-bold"><?= $transaksiHariIni ?></h4>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22);"><i class="fas fa-receipt"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">Dalam Proses</p>
                    <h4 class="mb-0 text-warning fw-bold"><?= $transaksiProses ?></h4>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);"><i class="fas fa-spinner"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="fas fa-database me-2"></i>Data Master</h5>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <?php if($role != 'kasir'): ?>
                        <tr>
                            <td class="py-2"><i class="fas fa-store text-primary me-2"></i> Total Outlet</td>
                            <td class="py-2 text-end"><strong><?= $totalOutlets ?> <span class="text-muted fw-normal">(aktif)</span></strong></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="<?= ($role == 'kasir') ? '' : 'border-bottom' ?>">
                            <td class="py-2"><i class="fas fa-users text-success me-2"></i> Total Member</td>
                            <td class="py-2 text-end"><strong><?= $totalMembers ?> <span class="text-muted fw-normal">(pelanggan)</span></strong></td>
                        </tr>
                        <?php if($role != 'kasir'): ?>
                        <tr>
                            <td class="py-2"><i class="fas fa-user-shield text-warning me-2"></i> Total Pengguna</td>
                            <td class="py-2 text-end"><strong><?= $totalUsers ?> <span class="text-muted fw-normal">(admin, kasir, owner)</span></strong></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>
                <div class="d-flex flex-column gap-2">
                    <?php if(!empty($logs)): ?>
                        <?php foreach($logs as $log): ?>
                        <div class="d-flex align-items-start p-2 rounded-3 bg-light">
                            <div class="bg-white rounded-circle p-2 me-3 shadow-sm" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-user text-muted" style="font-size: 14px;"></i>
                            </div>
                            <div>
                                <p class="mb-0" style="font-size: 0.85rem;"><strong><?= htmlspecialchars($log['user_name']) ?></strong></p>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($log['action']) ?></p>
                                <p class="mb-0 text-muted" style="font-size: 0.7rem;"><?= date('d M Y, H:i', strtotime($log['created_at'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center mt-3">Belum ada aktivitas.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>