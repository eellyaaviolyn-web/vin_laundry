<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        padding: 1rem;
    }

    .register-container {
        max-width: 450px;
        width: 100%;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
        background: white;
    }

    .card-header {
        background: transparent;
        border-bottom: 1px solid #eef2f6;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
        text-align: center;
    }

    .card-header h3 {
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
        color: #1a2c3e;
    }

    .card-header p {
        color: #6c7a89;
        font-size: 0.85rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        font-size: 0.85rem;
        color: #2c3e50;
        margin-bottom: 0.4rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dce4ec;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: 0.15s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .btn-register {
        background: #3b82f6;
        border: none;
        border-radius: 40px;
        padding: 0.6rem;
        font-weight: 500;
        font-size: 0.95rem;
        width: 100%;
    }

    .btn-register:hover {
        background: #2563eb;
    }

    .login-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    .divider {
        text-align: center;
        margin: 1rem 0;
        font-size: 0.8rem;
        color: #8ba0b5;
        position: relative;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: #e2e8f0;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <h3>Daftar</h3>
                <p>Buat akun baru</p>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                <div class="alert alert-danger py-2 small"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-2">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Outlet</label>
                        <select name="outlet_id" class="form-select" required>
                            <option value="">Pilih Outlet</option>
                            <?php foreach($outlets as $o): ?>
                            <option value="<?= $o['id'] ?>"><?= htmlspecialchars($o['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="register" class="btn btn-register text-white">Daftar</button>
                </form>
                <div class="divider">atau</div>
                <div class="text-center">
                    <span class="text-muted small">Sudah punya akun? </span>
                    <a href="index.php?page=login" class="login-link">Masuk</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>