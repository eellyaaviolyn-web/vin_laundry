<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-user-friends me-2"></i> Data Member</h3>
    <a href="?page=members&action=create" class="btn btn-primary-custom">Tambah Member</a>
</div>
<?php if(isset($_SESSION['success'])): ?>
<div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Outlet</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($members as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['name']) ?></td>
                    <td><?= htmlspecialchars($m['phone']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['outlet_name']) ?></td>
                    <td>
                        <a href="?page=members&action=edit&id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?page=members&action=delete&id=<?= $m['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin hapus member?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>