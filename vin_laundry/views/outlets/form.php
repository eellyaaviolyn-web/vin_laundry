<?php $isEdit = isset($data) && $data; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Outlet' : 'Tambah Outlet' ?> · Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        background: #f2f4f8;
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        padding: 2rem 1rem;
    }

    .form-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05), 0 2px 4px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .form-card:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .card-header-custom {
        background: white;
        border-bottom: 1px solid #eef2f6;
        padding: 1.25rem 1.5rem;
        border-radius: 1.25rem 1.25rem 0 0 !important;
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
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .btn-primary {
        background: #3b82f6;
        border: none;
        border-radius: 0.75rem;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: background 0.2s, transform 0.1s;
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
        font-weight: 500;
    }

    .btn-secondary:hover {
        background: #e6edf4;
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 0.85rem;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card form-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-store me-2" style="color:#3b82f6;"></i>
                            <?= $isEdit ? 'Edit Outlet' : 'Tambah Outlet' ?></h5>
                    </div>
                    <div class="card-body-custom">
                        <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form method="POST"
                            action="?page=outlets&action=<?= $isEdit ? 'edit&id='.$data['id'] : 'create' ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Outlet</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= $isEdit ? htmlspecialchars($data['name']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control"
                                    rows="2"><?= $isEdit ? htmlspecialchars($data['address']) : '' ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                    value="<?= $isEdit ? htmlspecialchars($data['phone']) : '' ?>">
                            </div>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?page=outlets" class="btn btn-secondary">Batal</a>
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