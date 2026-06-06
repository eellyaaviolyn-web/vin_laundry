<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-user-friends me-2"></i> Data Member</h3>
    <a href="?page=members&action=create" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Member
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
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Telp</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($members)): ?>
                    <?php foreach($members as $m): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><strong><?= htmlspecialchars($m['name']) ?></strong></td>
                        <td><?= htmlspecialchars($m['address']) ?></td>
                        <td><?= htmlspecialchars($m['jenis_kelamin']) ?></td>
                        <td><?= htmlspecialchars($m['phone']) ?></td>
                        <td>
                            <a href="?page=members&action=edit&id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="?page=members&action=delete&id=<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus member ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data member.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>