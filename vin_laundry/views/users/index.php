<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-users me-2"></i> Manajemen Pengguna</h3>
    <a href="?page=users&action=create" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah User
    </a>
</div>

<?php if(isset($_SESSION['success'])): ?>
<div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Outlet</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="badge bg-info"><?= $u['role'] ?></span></td>
                        <td><?= htmlspecialchars($u['outlet_name']) ?></td>
                        <td>
                            <a href="?page=users&action=edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning"><i
                                    class="fas fa-edit"></i></a>
                            <a href="?page=users&action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus user ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>