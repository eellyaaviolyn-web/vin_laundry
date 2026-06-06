<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Struk - <?= $print_data['kode_invoice'] ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #f0f0f0; margin: 0; padding: 20px; }
        .receipt { width: 350px; margin: 0 auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px dashed #ccc; padding-bottom: 10px; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 20px; color: #333; }
        .header p { margin: 2px 0; font-size: 12px; color: #555; }
        .info p { margin: 2px 0; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 12px; }
        th, td { padding: 6px 0; text-align: left; border-bottom: 1px solid #eee; }
        th { font-weight: bold; }
        .total-section { margin-top: 15px; border-top: 2px dashed #ccc; padding-top: 10px; }
        .total-section .row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px; }
        .grand-total { font-size: 18px; font-weight: bold; margin-top: 10px !important; }
        .footer { text-align: center; margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 10px; font-size: 11px; color: #777; }
        .no-print { text-align: center; margin-bottom: 20px; }
        .no-print button { padding: 10px 20px; font-size: 16px; background: #1abc9c; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        
        @media print {
            body { background: white; padding: 0; }
            .receipt { box-shadow: none; margin: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()"><i class="fas fa-print"></i> Cetak Sekarang</button>
    <button onclick="window.close()" style="background:#ccc; color:#333;">Tutup</button>
</div>

<div class="receipt">
    <div class="header">
        <h2>LAUNDRY PRO</h2>
        <p><?= htmlspecialchars($print_data['outlet_name']) ?></p>
        <p><?= htmlspecialchars($print_data['outlet_address'] ?? '') ?></p>
        <p>Telp: <?= htmlspecialchars($print_data['outlet_phone'] ?? '-') ?></p>
    </div>

    <div class="info">
        <p><strong>No Invoice:</strong> <?= $print_data['kode_invoice'] ?></p>
        <p><strong>Tanggal:</strong> <?= date('d-m-Y', strtotime($print_data['tanggal'])) ?></p>
        <p><strong>Diambil:</strong> <?= date('d-m-Y', strtotime($print_data['batas_waktu'])) ?></p>
        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($print_data['member_name']) ?> (<?= $print_data['member_phone'] ?>)</p>
        <p><strong>Status:</strong> <?= ucfirst($print_data['status']) ?> | <strong>Bayar:</strong> <?= ucfirst($print_data['dibayar']) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($print_data['details'] as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['paket_name']) ?></td>
                <td><?= $d['qty'] ?></td>
                <td><?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= number_format($d['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-section">
        <div class="row">
            <span>Subtotal:</span>
            <span>Rp <?= number_format(array_sum(array_column($print_data['details'], 'subtotal')), 0, ',', '.') ?></span>
        </div>
        <?php if($print_data['diskon'] > 0): ?>
        <div class="row">
            <span>Diskon (<?= $print_data['diskon'] ?>%):</span>
            <span>- Rp <?= number_format(array_sum(array_column($print_data['details'], 'subtotal')) * ($print_data['diskon'] / 100), 0, ',', '.') ?></span>
        </div>
        <?php endif; ?>
        <?php if($print_data['biaya_tambahan'] > 0): ?>
        <div class="row">
            <span>Biaya Tambahan:</span>
            <span>Rp <?= number_format($print_data['biaya_tambahan'], 0, ',', '.') ?></span>
        </div>
        <?php endif; ?>
        <div class="row grand-total">
            <span>TOTAL:</span>
            <span>Rp <?= number_format($print_data['total_biaya'], 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>~ Laundry Pro ~</p>
    </div>
</div>

</body>
</html>