<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-box me-2"></i> Paket</h3>
    <a href="?page=paket&action=create" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Paket
    </a>
</div>

<?php if(isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Outlet</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pakets) && count($pakets) > 0): ?>
                    <?php foreach($pakets as $p): ?>
                    <?php
                        // Ambil nama outlet
                        $outletNama = '-';
                        if (!empty($outlets)) {
                            foreach ($outlets as $o) {
                                if ($o['id'] == ($p['outlet_id'] ?? '')) {
                                    $outletNama = htmlspecialchars($o['name']);
                                    break;
                                }
                            }
                        }
                    ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['name'] ?? $p['nama'] ?? '-') ?></strong></td>
                        <td>Rp <?= number_format($p['price'] ?? $p['harga'] ?? 0, 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['unit'] ?? $p['satuan'] ?? '-') ?></td>
                        <td><?= $outletNama ?></td>
                        <td>
                            <a href="?page=paket&action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="?page=paket&action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus paket ini?')" data-bs-toggle="tooltip"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data paket. Silakan tambah paket baru.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>