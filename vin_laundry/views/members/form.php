<?php
// Ambil data outlet jika diperlukan (untuk kasir yang hanya punya 1 outlet)
 $outletModel = new \LaundryApp\Models\Outlet();
 $outlets = $outletModel->getAll();
?>

<style>
    .mb-card {
        max-width: 700px;
        margin: 0 auto;
        animation: mbFadeUp 0.5s ease;
    }
    @keyframes mbFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .mb-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .mb-header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        box-shadow: 0 8px 24px rgba(26, 188, 156, 0.3);
    }
    .mb-header-icon svg {
        width: 28px;
        height: 28px;
        fill: none;
        stroke: #fff;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .mb-header h4 {
        font-size: 24px;
        font-weight: 800;
        color: #1e2a3a;
        letter-spacing: -0.5px;
        font-family: 'Poppins', sans-serif;
    }
    .mb-header p {
        font-size: 14px;
        color: #94a3b8;
        margin-top: 4px;
        font-family: 'Poppins', sans-serif;
    }
    .mb-card-box {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04), 0 12px 40px rgba(0,0,0,0.03);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .mb-card-body {
        padding: 32px;
    }
    .mb-section {
        margin-bottom: 24px;
    }
    .mb-section-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #1abc9c;
        margin-bottom: 16px;
        font-family: 'Poppins', sans-serif;
    }
    .mb-section-label .mb-dot {
        width: 8px;
        height: 8px;
        background: #1abc9c;
        border-radius: 50%;
    }
    .mb-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .mb-grid-full { grid-column: 1 / -1; }
    .mb-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
        font-family: 'Poppins', sans-serif;
    }
    .mb-field label .mb-required {
        color: #ef4444;
        margin-left: 2px;
    }
    .mb-field select,
    .mb-field input {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
        transition: all 0.25s ease;
    }
    .mb-field select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%2394a3b8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
        cursor: pointer;
    }
    .mb-field select:focus,
    .mb-field input:focus {
        border-color: #1abc9c;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.1), 0 1px 3px rgba(26, 188, 156, 0.08);
    }
    .mb-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }
    .mb-btn-submit {
        flex: 1;
        padding: 14px 24px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .mb-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(26, 188, 156, 0.4);
    }
    .mb-btn-cancel {
        padding: 14px 28px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .mb-btn-cancel:hover {
        border-color: #cbd5e1;
        color: #334155;
        background: #f8fafc;
    }
    @media (max-width: 600px) {
        .mb-grid { grid-template-columns: 1fr; }
        .mb-card-body { padding: 20px; }
        .mb-actions { flex-direction: column; }
    }
</style>

<div class="mb-card">
    <div class="mb-header">
        <div class="mb-header-icon">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </div>
        <h4><?= isset($data) ? 'Edit Member' : 'Tambah Member' ?></h4>
        <p><?= isset($data) ? 'Ubah data pelanggan yang terdaftar' : 'Isi data untuk menambah pelanggan baru' ?></p>
    </div>

    <div class="mb-card-box">
    <div class="mb-card-body">
        <form method="POST">
            
            <!-- Data Diri -->
            <div class="mb-section">
                <div class="mb-section-label">
                    <span class="mb-dot"></span> Data Diri
                </div>
                <div class="mb-grid">
                    <div class="mb-field mb-grid-full">
                        <label>Nama Lengkap <span class="mb-required">*</span></label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap..." value="<?= isset($data) ? htmlspecialchars($data['name']) : '' ?>" required>
                    </div>
                    <div class="mb-field">
                        <label>Jenis Kelamin <span class="mb-required">*</span></label>
                        <select name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= (isset($data) && $data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= (isset($data) && $data['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-field">
                        <label>No. Telepon <span class="mb-required">*</span></label>
                        <input type="text" name="telp" id="inputTelp" placeholder="Contoh: 08123456789" onkeypress="return hanyaAngka(event)" value="<?= isset($data) ? htmlspecialchars($data['phone']) : '' ?>" required>
                    </div>
                </div>
            </div>

            <!-- Alamat & Outlet -->
            <div class="mb-section">
                <div class="mb-section-label">
                    <span class="mb-dot"></span> Detail Lainnya
                </div>
                <div class="mb-grid">
                    <div class="mb-field mb-grid-full">
                        <label>Alamat <span class="mb-required">*</span></label>
                        <input type="text" name="alamat" placeholder="Masukkan alamat lengkap..." value="<?= isset($data) ? htmlspecialchars($data['address']) : '' ?>" required>
                    </div>
                    
                    <!-- Outlet disembunyikan tapi tetap dikirim (Kalau Admin, munculkan dropdown. Kalau Kasir, hidden) -->
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                    <div class="mb-field mb-grid-full">
                        <label>Outlet</label>
                        <select name="outlet_id">
                            <?php foreach($outlets as $o): ?>
                            <option value="<?= $o['id'] ?>" <?= (isset($data) && $data['outlet_id'] == $o['id']) || (!isset($data) && $o['id'] == $_SESSION['outlet_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="outlet_id" value="<?= $_SESSION['outlet_id'] ?>">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tombol -->
            <div class="mb-actions">
                <button type="submit" class="mb-btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Data
                </button>
                <a href="index.php?page=members" class="mb-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
    </div>
</div>

<script>
// Validasi: Hanya boleh angka di No. Telepon
function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>