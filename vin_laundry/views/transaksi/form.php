<?php
 $is_edit = isset($tx_data) && $tx_data;
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<?php if (isset($error)): ?>
<div style="background: #fef2f2; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 12px; color: #991b1b; margin-bottom: 20px; font-size: 14px; max-width: 740px; margin-left: auto; margin-right: auto;">
    ⚠️ <strong>Error:</strong> <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
* { margin: 0; padding: 0; box-sizing: border-box; }
body { background: #f4f6fb; font-family: 'Inter', sans-serif; }
.tx-page { min-height: 100vh; padding: 40px 20px; background: radial-gradient(ellipse at 20% 0%, rgba(99,102,241,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 100%, rgba(236,72,153,0.06) 0%, transparent 50%), #f4f6fb); }
.tx-container { max-width: 740px; margin: 0 auto; animation: txFadeUp 0.5s ease; }
@keyframes txFadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.tx-header { text-align: center; margin-bottom: 32px; }
.tx-header-icon { width: 56px; height: 56px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 8px 24px rgba(99,102,241,0.3); }
.tx-header-icon svg { width: 28px; height: 28px; fill: none; stroke: #fff; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.tx-header h4 { font-size: 24px; font-weight: 800; color: #1e1b4b; letter-spacing: -0.5px; }
.tx-header p { font-size: 14px; color: #94a3b8; margin-top: 4px; }
.tx-card { background: #fff; border-radius: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04), 0 12px 40px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid rgba(0,0,0,0.04); }
.tx-card-body { padding: 32px; }
.tx-section { margin-bottom: 28px; }
.tx-section:last-child { margin-bottom: 0; }
.tx-section-label { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6366f1; margin-bottom: 16px; }
.tx-section-label .tx-dot { width: 8px; height: 8px; background: #6366f1; border-radius: 50%; }
.tx-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.tx-grid-full { grid-column: 1 / -1; }
.tx-field label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 7px; }
.tx-field label .tx-required { color: #ef4444; margin-left: 2px; }
.tx-field select, .tx-field input { width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1e293b; background: #f8fafc; outline: none; transition: all 0.25s ease; }
.tx-field select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%2394a3b8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
.tx-field select:disabled, .tx-field input:disabled { background: #f1f5f9; color: #64748b; cursor: not-allowed; border-style: dashed; border-color: #cbd5e1; }
.tx-field select:focus, .tx-field input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.tx-field input[readonly] { background: #f1f5f9; color: #6366f1; font-weight: 700; border-style: dashed; border-color: #c7d2fe; cursor: default; }
.tx-divider { height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent); margin: 28px 0; }
.tx-detail-row { display: flex; gap: 10px; margin-bottom: 10px; animation: txFadeUp 0.3s ease; }
.tx-col-paket { flex: 5; } .tx-col-qty { flex: 2; } .tx-col-sub { flex: 2; } .tx-col-btn { flex: 0 0 42px; display: flex; align-items: flex-end; }
.tx-field-sub input { background: #f1f5f9 !important; color: #6366f1 !important; font-weight: 700 !important; font-size: 13px !important; cursor: default; border-style: dashed !important; }
.tx-btn-remove { width: 42px; height: 42px; border-radius: 10px; border: 1.5px solid #fee2e2; background: #fff5f5; color: #f87171; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
.tx-btn-remove:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
.tx-btn-add { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; border: 2px dashed #c7d2fe; background: #eef2ff; color: #6366f1; font-size: 13px; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.25s ease; margin-top: 4px; }
.tx-btn-add:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
.tx-btn-add svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; }
.tx-total-wrapper { margin-top: 28px; padding: 20px 24px; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%); border-radius: 16px; display: flex; justify-content: space-between; align-items: center; overflow: hidden; }
.tx-total-label { color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500; position: relative; z-index: 1; }
.tx-total-input { background: transparent; border: none; color: #fff; font-size: 26px; font-weight: 900; text-align: right; width: 220px; outline: none; font-family: 'Inter', sans-serif; letter-spacing: -0.5px; position: relative; z-index: 1; }
.tx-actions { display: flex; gap: 12px; margin-top: 24px; }
.tx-btn-submit { flex: 1; padding: 14px 24px; border-radius: 12px; border: none; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: #fff; font-size: 15px; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 8px; }
.tx-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(99,102,241,0.4); }
.tx-btn-submit svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }
.tx-btn-cancel { padding: 14px 28px; border-radius: 12px; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none; transition: all 0.2s ease; }
.tx-btn-cancel:hover { border-color: #cbd5e1; color: #334155; background: #f8fafc; }
@media (max-width: 600px) { .tx-grid { grid-template-columns: 1fr; } .tx-detail-row { flex-wrap: wrap; } .tx-col-paket { flex: 1 1 100%; } .tx-col-qty { flex: 1; } .tx-col-sub { flex: 1; } .tx-col-btn { flex: 0 0 100%; justify-content: flex-end; margin-top: -4px; } .tx-total-wrapper { flex-direction: column; gap: 6px; text-align: center; } .tx-total-input { width: 100%; text-align: center; font-size: 22px; } .tx-card-body { padding: 20px; } .tx-actions { flex-direction: column; } }
</style>

<div class="tx-page">
<div class="tx-container">
    <div class="tx-header">
        <div class="tx-header-icon">
            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <h4><?= $is_edit ? 'Edit Transaksi' : 'Transaksi Baru' ?></h4>
        <p><?= $is_edit ? 'Ubah data transaksi laundry' : 'Isi data di bawah untuk membuat transaksi laundry' ?></p>
    </div>

    <div class="tx-card">
    <div class="tx-card-body">
        <form method="POST" id="formTransaksi">
            
            <!-- Info Pelanggan -->
            <div class="tx-section">
                <div class="tx-section-label">
                    <span class="tx-dot"></span> Info Pelanggan
                </div>
                <div class="tx-grid">
                    <div class="tx-field">
                        <label>Outlet</label>
                        <select name="outlet_id" id="outletSelect" disabled>
                            <option value="">-- Pilih Pelanggan Dulu --</option>
                            <?php 
                            $outletModel = new \LaundryApp\Models\Outlet();
                            $allOutlets = $outletModel->getAll();
                            foreach($allOutlets as $o): 
                                $selected = ($is_edit && isset($tx_data['outlet_id']) && $tx_data['outlet_id'] == $o['id']) ? 'selected' : '';
                                echo '<option value="'.$o['id'].'" '.$selected.'>'.htmlspecialchars($o['name']).'</option>';
                            endforeach; 
                            ?>
                        </select>
                    </div>

                    <div class="tx-field">
                        <label>Pelanggan <span class="tx-required">*</span></label>
                        <select name="member_id" id="memberSelect" required>
                            <option value="">Pilih Pelanggan...</option>
                            <?php if(!empty($members)): ?>
                                <?php foreach($members as $m): ?>
                                <?php
                                    $sel = ($is_edit && isset($tx_data['member_id']) && $tx_data['member_id'] == $m['id']) ? 'selected' : '';
                                ?>
                                <option value="<?= $m['id'] ?>" data-outlet="<?= $m['outlet_id'] ?? '' ?>" <?= $sel ?>><?= htmlspecialchars($m['name']) ?> — <?= htmlspecialchars($m['phone'] ?? '') ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>⚠️ Belum ada pelanggan terdaftar</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Waktu Pembelian -->
                    <div class="tx-field">
                        <label>📅 Waktu Pembelian</label>
                        <?php 
                            $tglVal = date('Y-m-d\TH:i');
                            if ($is_edit && isset($tx_data['tgl_pembelian']) && $tx_data['tgl_pembelian']) {
                                $tglVal = $tx_data['tgl_pembelian'];
                            } elseif ($is_edit && isset($tx_data['created_at']) && $tx_data['created_at']) {
                                $tglVal = date('Y-m-d\TH:i', strtotime($tx_data['created_at']));
                            }
                        ?>
                        <input type="datetime-local" name="tgl_pembelian" value="<?= $tglVal ?>" style="background:#fff !important; border-style:solid !important; cursor:text !important;">
                    </div>

                    <!-- Batas Pengembalian -->
                    <div class="tx-field">
                        <label>🔄 Batas Pengembalian <span class="tx-required"></span></label>
                        <input type="datetime-local" name="tgl_pembelian" value="<?= $tglVal ?>" style="background:#fff !important; border-style:solid !important; cursor:text !important;">
                    </div>
                </div>
            </div>

            <div class="tx-divider"></div>

            <!-- Detail Paket -->
            <div class="tx-section">
                <div class="tx-section-label">
                    <span class="tx-dot"></span> Detail Paket
                </div>
                <div id="detailContainer">
                    <?php if($is_edit && !empty($tx_data['details'])): ?>
                        <?php foreach($tx_data['details'] as $d): ?>
                        <div class="tx-detail-row detail-row">
                            <div class="tx-col-paket tx-field">
                                <label>Paket</label>
                                <select name="paket_id[]" class="paket-select">
                                    <option value="">Pilih Paket...</option>
                                    <?php if(!empty($pakets)): ?>
                                        <?php foreach($pakets as $p): ?>
                                        <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga'] ?? 0 ?>" data-outlet="<?= $p['outlet_id'] ?? '' ?>" <?= (isset($d['paket_id']) && $p['id'] == $d['paket_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['name']) ?> — Rp <?= number_format($p['harga'] ?? 0, 0, ',', '.') ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="tx-col-qty tx-field">
                                <label>Qty</label>
                                <input type="number" name="qty[]" class="input-qty" value="<?= $d['qty'] ?? 0 ?>" placeholder="0" min="0.1" step="0.1">
                            </div>
                            <div class="tx-col-sub tx-field tx-field-sub">
                                <label>Subtotal</label>
                                <input type="text" class="subtotal-display" value="Rp <?= number_format($d['subtotal'] ?? 0, 0, ',', '.') ?>" readonly tabindex="-1">
                            </div>
                            <div class="tx-col-btn">
                                <button type="button" class="tx-btn-remove removeDetail">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <div class="tx-detail-row detail-row">
                        <div class="tx-col-paket tx-field">
                            <label>Paket</label>
                            <select name="paket_id[]" class="paket-select">
                                <option value="">Pilih Paket...</option>
                                <?php if(!empty($pakets)): ?>
                                    <?php foreach($pakets as $p): ?>
                                    <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga'] ?? 0 ?>" data-outlet="<?= $p['outlet_id'] ?? '' ?>">
                                        <?= htmlspecialchars($p['name']) ?> — Rp <?= number_format($p['harga'] ?? 0, 0, ',', '.') ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="tx-col-qty tx-field">
                            <label>Qty</label>
                            <input type="number" name="qty[]" class="input-qty" placeholder="0" min="0.1" step="0.1">
                        </div>
                        <div class="tx-col-sub tx-field tx-field-sub">
                            <label>Subtotal</label>
                            <input type="text" class="subtotal-display" value="Rp 0" readonly tabindex="-1">
                        </div>
                        <div class="tx-col-btn">
                            <button type="button" class="tx-btn-remove removeDetail">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <button type="button" id="addDetail" class="tx-btn-add">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Paket
                </button>
            </div>

            <div class="tx-divider"></div>

            <!-- Lainnya -->
            <div class="tx-section">
                <div class="tx-section-label">
                    <span class="tx-dot"></span> Lainnya
                </div>
                <div class="tx-grid">
                    <div class="tx-field">
                        <label>Diskon (%)</label>
                        <input type="number" name="diskon" value="<?= $is_edit ? ($tx_data['diskon'] ?? 0) : '0' ?>" min="0" max="100" step="1" placeholder="0">
                    </div>
                    <div class="tx-field">
                        <label>Catatan</label>
                        <input type="text" name="notes" value="<?= $is_edit ? ($tx_data['notes'] ?? '') : '' ?>" placeholder="Opsional...">
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="tx-total-wrapper">
                <span class="tx-total-label">Total Biaya</span>
                <input type="text" id="totalDisplay" class="tx-total-input" value="Rp 0" readonly>
            </div>

            <!-- Actions -->
            <div class="tx-actions">
                <button type="submit" class="tx-btn-submit">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <?= $is_edit ? 'Update Transaksi' : 'Simpan Transaksi' ?>
                </button>
                <a href="index.php?page=transaksi" class="tx-btn-cancel">Batal</a>
            </div>

        </form>
    </div>
    </div>
</div>
</div>

<script>
document.getElementById('addDetail').addEventListener('click', function() {
    let container = document.getElementById('detailContainer');
    let newRow = container.querySelector('.detail-row').cloneNode(true);
    newRow.querySelector('.paket-select').value = '';
    newRow.querySelector('.input-qty').value = '';
    newRow.querySelector('.subtotal-display').value = 'Rp 0';
    
    let outletId = document.getElementById('outletSelect').value;
    if (outletId) {
        filterPaketByOutlet(outletId);
    }
    
    container.appendChild(newRow);
});

document.addEventListener('click', function(e) {
    let btn = e.target.closest('.removeDetail');
    if (btn) {
        if (document.querySelectorAll('.detail-row').length > 1) {
            let row = btn.closest('.detail-row');
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            row.style.transition = 'all 0.25s ease';
            setTimeout(function() { row.remove(); hitungTotal(); }, 250);
        }
    }
});

document.addEventListener('change input', function(e) {
    if (e.target.classList.contains('paket-select') || e.target.classList.contains('input-qty') || e.target.name === 'diskon') {
        hitungTotal();
    }
});

document.getElementById('memberSelect').addEventListener('change', function() {
    let memberSelect = document.getElementById('memberSelect');
    let outletSelect = document.getElementById('outletSelect');
    
    if (memberSelect.value) {
        let selectedOption = memberSelect.options[memberSelect.selectedIndex];
        let outletId = selectedOption.getAttribute('data-outlet');
        outletSelect.value = outletId;
        outletSelect.disabled = true;
        
        filterPaketByOutlet(outletId);
        hitungTotal();
    } else {
        outletSelect.value = '';
        outletSelect.disabled = true;
    }
});

function filterPaketByOutlet(outletId) {
    document.querySelectorAll('.detail-row').forEach(function(row) {
        let paketSelect = row.querySelector('.paket-select');
        let options = paketSelect.options;
        
        for (let i = 0; i < options.length; i++) {
            let optOutlet = options[i].getAttribute('data-outlet');
            if (optOutlet && optOutlet !== String(outletId)) {
                options[i].style.display = 'none';
                if (options[i].selected) { options[i].selected = false; }
            } else if (optOutlet === String(outletId)) {
                options[i].style.display = '';
            }
        }
        
        if (paketSelect.selectedIndex >= 0 && paketSelect.options[paketSelect.selectedIndex].style.display === 'none') {
            paketSelect.value = '';
        }
    });
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.detail-row').forEach(function(row) {
        let s = row.querySelector('.paket-select');
        let q = parseFloat(row.querySelector('.input-qty').value) || 0;
        let h = parseFloat(s.options[s.selectedIndex].getAttribute('data-harga')) || 0;
        let sub = h * q;
        row.querySelector('.subtotal-display').value = 'Rp ' + sub.toLocaleString('id-ID');
        total += sub;
    });
    let diskonPersen = parseFloat(document.querySelector('input[name="diskon"]').value) || 0;
    let diskonRupiah = total * (diskonPersen / 100);
    let totalAkhir = total - diskonRupiah;
    let display = 'Rp ' + totalAkhir.toLocaleString('id-ID');
    if (diskonPersen > 0) { display += '  (-' + diskonPersen + '%)'; }
    document.getElementById('totalDisplay').value = display;
}

window.addEventListener('DOMContentLoaded', function() { 
    let outletId = document.getElementById('outletSelect').value;
    if (outletId) {
        document.getElementById('outletSelect').value = outletId;
        document.getElementById('outletSelect').disabled = true;
        filterPaketByOutlet(outletId);
    }
    hitungTotal(); 
});

document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    let memberSelect = document.getElementById('memberSelect');
    if (!memberSelect.value) {
        e.preventDefault();
        alert('Silakan pilih pelanggan terlebih dahulu!');
        memberSelect.focus();
        return false;
    }
    return true;
});
</script>