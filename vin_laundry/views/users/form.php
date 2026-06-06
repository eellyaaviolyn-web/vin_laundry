<?php $isEdit = isset($data) && $data; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit User' : 'Tambah User' ?> · Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        background: #f2f4f8;
        font-family: 'Inter', system-ui, sans-serif;
        padding: 2rem 1rem;
    }

    .form-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .card-header-custom {
        background: white;
        border-bottom: 1px solid #eef2f6;
        padding: 1.25rem 1.5rem;
        border-radius: 1.25rem 1.25rem 0 0;
    }

    .card-header-custom h5 {
        font-weight: 600;
        margin: 0;
        color: #1a2c3e;
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        color: #2c3e50;
    }

    .form-control,
    .form-select {
        border: 1px solid #dce4ec;
        border-radius: 0.75rem;
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-primary {
        background: #3b82f6;
        border: none;
        border-radius: 0.75rem;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        border-radius: 0.75rem;
        padding: 0.6rem 1.2rem;
    }

    .btn-secondary:hover {
        background: #e6edf4;
    }

    .alert {
        border-radius: 0.75rem;
        background: #fee2e2;
        color: #b91c1c;
    }

    small.text-muted {
        font-size: 0.7rem;
        color: #6c757d;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card form-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-users me-2" style="color:#3b82f6;"></i>
                            <?= $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna' ?></h5>
                    </div>
                    <div class="card-body-custom">
                        <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form method="POST"
                            action="?page=users&action=<?= $isEdit ? 'edit&id='.$data['id'] : 'create' ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= $isEdit ? htmlspecialchars($data['name']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= $isEdit ? htmlspecialchars($data['email']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    <?= $isEdit ? '' : 'required' ?>>
                                <?php if($isEdit): ?>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="admin" <?= ($isEdit && $data['role']=='admin')?'selected':'' ?>>Admin
                                    </option>
                                    <option value="kasir" <?= ($isEdit && $data['role']=='kasir')?'selected':'' ?>>Kasir
                                    </option>
                                    <option value="owner" <?= ($isEdit && $data['role']=='owner')?'selected':'' ?>>Owner
                                    </option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Outlet</label>
                                <select name="outlet_id" class="form-select" required>
                                    <option value="">Pilih Outlet</option>
                                    <?php foreach($outlets as $o): ?>
                                    <option value="<?= $o['id'] ?>"
                                        <?= ($isEdit && $data['outlet_id']==$o['id'])?'selected':'' ?>>
                                        <?= htmlspecialchars($o['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?page=users" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>