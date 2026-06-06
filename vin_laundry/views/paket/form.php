<?php
 $isEdit = isset($data);
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<?php if (isset($error)): ?>
<div style="background: #fef2f2; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 12px; color: #991b1b; margin-bottom: 20px; font-size: 14px; max-width: 600px; margin-left: auto; margin-right: auto;">
    ⚠️ <strong>Error:</strong> <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<style>
.pk-page { min-height: 100vh; padding: 40px 20px; background: radial-gradient(ellipse at 20% 0%, rgba(243,156,18,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 100%, rgba(231,76,60,0.06) 0%, transparent 50%), #f4f6fb); }
.pk-container { max-width: 600px; margin: 0 auto; animation: pkFadeUp 0.5s ease; }
@keyframes pkFadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.pk-header { text-align: center; margin-bottom: 32px; }
.pk-header-icon { width: 56px; height: 56px; background: linear-gradient(135deg, #f39c12, #e67e22); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 8px 24px rgba(243,156,18,0.3); }
.pk-header-icon svg { width: 28px; height: 28px; fill: none; stroke: #fff; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.pk-header h4 { font-size: 24px; font-weight: 800; color: #1e1b4b; letter-spacing: -0.5px; }
.pk-header p { font-size: 14px; color: #94a3b8; margin-top: 4px; }
.pk-card { background: #fff; border-radius: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04), 0 12px 40px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid rgba(0,0,0,0.04); }
.pk-card-body { padding: 32px; }
.pk-section { margin-bottom: 28px; }
.pk-section:last-child { margin-bottom: 0; }
.pk-section-label { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #f39c12; margin-bottom: 16px; }
.pk-section-label .pk-dot { width: 8px; height: 8px; background: #f39c12; border-radius: 50%; }
.pk-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pk-grid-full { grid-column: 1 / -1; }
.pk-field label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 7px; }
.pk-field label .pk-required { color: #ef4444; margin-left: 2px; }
.pk-field select, .pk-field input, .pk-field textarea { width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.25s ease; }
.pk-field select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%2394a3b8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
.pk-field select:focus, .pk-field input:focus, .pk-field textarea:focus { border-color: #f39c12; background: #fff; box-shadow: 0 0 0 3px rgba(243,156,18,0.1); }
.pk-field textarea { resize: vertical; min-height: 80px; }
.pk-divider { height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent); margin: 28px 0; }
.pk-actions { display: flex; gap: 12px; margin-top: 24px; }
.pk-btn-submit { flex: 1; padding: 14px 24px; border-radius: 12px; border: none; background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: #fff; font-size: 15px; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 8px; }
.pk-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(243,156,18,0.4); }
.pk-btn-cancel { padding: 14px 28px; border-radius: 12px; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none; transition: all 0.2s ease; }
.pk-btn-cancel:hover { border-color: #cbd5e1; color: #334155; background: #f8fafc; }
@media (max-width: 600px) { .pk-grid { grid-template-columns: 1fr; } .pk-card-body { padding: 20px; } .pk-actions { flex-direction: column; } }
</style>

<div class="pk-page">
<div class="pk-container">
    <div class="pk-header">
        <div class="pk-header-icon">
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <h4><?= $isEdit ? 'Edit Paket' : 'Tambah Paket' ?></h4>
        <p><?= $isEdit ? 'Ubah data paket laundry' : 'Isi data di bawah untuk menambah paket baru' ?></p>
    </div>

    <div class="pk-card">
    <div class="pk-card-body">
        <form method="POST">
            
            <div class="pk-section">
                <div class="pk-section-label">
                    <span class="pk-dot"></span> Info Paket
                </div>
                <div class="pk-grid">
                    <div class="pk-grid-full pk-field">
                        <label>Nama Paket <span class="pk-required">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: Express Kiloan" value="<?= $isEdit ? htmlspecialchars($data['name'] ?? '') : '' ?>" required>
                    </div>
                    <div class="pk-field">
                        <label>Harga <span class="pk-required">*</span></label>
                        <input type="number" name="price" placeholder="0" step="500" min="0" value="<?= $isEdit ? ($data['harga'] ?? '') : '' ?>" required>
                    </div>
                    <div class="pk-field">
                        <label>Jenis</label>
                        <input type="text" name="unit" placeholder="kg" value="<?= $isEdit ? htmlspecialchars($data['jenis'] ?? '') : 'kg' ?>">
                    </div>
                </div>
            </div>

            <div class="pk-divider"></div>

            <div class="pk-section">
                <div class="pk-section-label">
                    <span class="pk-dot"></span> Lainnya
                </div>
                <div class="pk-grid">
                    <div class="pk-grid-full pk-field">
                        <label>Deskripsi</label>
                        <textarea name="description" placeholder="Opsional..."><?= $isEdit ? htmlspecialchars($data['deskripsi'] ?? '') : '' ?></textarea>
                    </div>
                    <div class="pk-grid-full pk-field">
                        <label>Outlet <span class="pk-required">*</span></label>
                        <select name="outlet_id" required>
                            <option value="">Pilih Outlet...</option>
                            <?php foreach ($outlets as $o): ?>
                                <option value="<?= $o['id'] ?>" <?= ($isEdit && isset($data['outlet_id']) && $data['outlet_id'] == $o['id']) ? 'selected' : '' ?>><?= htmlspecialchars($o['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pk-actions">
                <button type="submit" class="pk-btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <?= $isEdit ? 'Update Paket' : 'Simpan Paket' ?>
                </button>
                <a href="?page=paket" class="pk-btn-cancel">Batal</a>
            </div>

        </form>
    </div>
    </div>
</div>
</div>