<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-store me-2"></i> Manajemen Outlet</h3>
    <a href="?page=outlets&action=create" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Outlet
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
                        <th>Nama Outlet</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($outlets) > 0): ?>
                    <?php foreach($outlets as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td><strong><?= htmlspecialchars($o['name']) ?></strong></td>
                        <td><?= htmlspecialchars($o['address']) ?></td>
                        <td><?= htmlspecialchars($o['phone']) ?></td>
                        <td>
                            <a href="?page=outlets&action=edit&id=<?= $o['id'] ?>" class="btn btn-sm btn-warning"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="?page=outlets&action=delete&id=<?= $o['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus outlet ini?')" data-bs-toggle="tooltip"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data outlet. Silakan tambah outlet
                            baru.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>