<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

 $start_date       = $start_date ?? date('Y-m-01');
 $end_date         = $end_date ?? date('Y-m-t');
 $total_pendapatan = $total_pendapatan ?? 0;
 $laporan          = $laporan ?? [];

 $tglMulai = date('d F Y', strtotime($start_date));
 $tglAkhir = date('d F Y', strtotime($end_date));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - LaundryPro</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 30px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { font-size: 20px; letter-spacing: 2px; }
        .header p { font-size: 12px; color: #666; margin-top: 4px; }
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 13px; }
        .info span { color: #555; }
        .info strong { color: #222; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        thead th { background: #1e2a3a; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody td { padding: 8px; border-bottom: 1px solid #eee; }
        tbody tr:nth-child(even) { background: #f9f9f9; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row td { background: #f0f0f0 !important; font-weight: 700; font-size: 13px; border-top: 2px solid #333; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; }
        .footer .box { text-align: center; font-size: 12px; }
        .footer .box .line { margin-top: 60px; border-bottom: 1px solid #333; width: 150px; margin-left: auto; margin-right: auto; }
        @media print {
            body { padding: 15px; }
            .no-print { display: none !important; }
            @page { margin: 15mm; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAUNDRY PRO</h2>
        <p>Laporan Transaksi Laundry</p>
    </div>

        <div class="info">
        <span>Periode: <strong><?= $tglMulai ?> — <?= $tglAkhir ?></strong></span>
        <span>Total Transaksi: <strong><?= count($laporan) ?></strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Outlet</th>
                <th class="text-right">Total Paket</th>
                <th class="text-right">Tambahan</th>
                <th class="text-center">Diskon</th>
                <th class="text-right">Final</th>
                <th class="text-center">Status</th>
                <th class="text-center">Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($laporan) > 0): ?>
                <?php $no = 1; $grandTotal = 0; foreach ($laporan as $row): ?>
                <?php
                    $totalPaket    = (float) ($row['total_paket'] ?? 0);
                    $biayaTambahan = (float) ($row['biaya_tambahan'] ?? 0);
                    $diskonPersen  = (float) ($row['diskon'] ?? 0);
                    $diskonRupiah  = $totalPaket * ($diskonPersen / 100);
                    $finalPrice    = ($totalPaket + $biayaTambahan) - $diskonRupiah;
                    $grandTotal   += $finalPrice;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['kode_invoice'] ?? '-') ?></strong></td>
                    <td><?= htmlspecialchars($row['tanggal'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['member_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['outlet_name'] ?? '-') ?></td>
                    <td class="text-right"><?= number_format($totalPaket, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($biayaTambahan, 0, ',', '.') ?></td>
                    <td class="text-center"><?= number_format($diskonPersen, 0, ',', '.') ?>%</td>
                    <td class="text-right"><strong><?= number_format($finalPrice, 0, ',', '.') ?></strong></td>
                    <td class="text-center"><?= ucfirst($row['status'] ?? '-') ?></td>
                    <td class="text-center"><?= ucfirst($row['dibayar'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="11" class="text-center">Tidak ada data transaksi</td></tr>
            <?php endif; ?>
            <tr class="total-row">
                <td colspan="8" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="box">
            <p>Pelanggan</p>
            <div class="line"></div>
        </div>
        <div class="box">
            <p>Kasir</p>
            <div class="line"></div>
        </div>
        <div class="box">
            <p>Admin</p>
            <div class="line"></div>
        </div>
    </div>

    <div class="no-print" style="margin-top:30px; text-align:center;">
        <button onclick="window.print()" style="padding:12px 30px; background:#1e2a3a; color:white; border:none; border-radius:8px; font-size:14px; cursor:pointer; font-weight:600;">
            🖨️ Cetak Sekarang
        </button>
        <button onclick="window.close()" style="padding:12px 30px; background:#6c757d; color:white; border:none; border-radius:8px; font-size:14px; cursor:pointer; font-weight:600; margin-left:10px;">
            ✕ Tutup
        </button>
    </div>

    <script>
        var d = new Date();
        var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var tgl = d.getDate();
        var bln = bulan[d.getMonth()];
        var thn = d.getFullYear();
        var jam = String(d.getHours()).padStart(2,'0');
        var menit = String(d.getMinutes()).padStart(2,'0');
        document.getElementById('waktuCetak').textContent = tgl + ' ' + bln + ' ' + thn + ', ' + jam + ':' + menit;
    </script>

</body>
</html>