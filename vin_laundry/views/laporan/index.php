<?php
 $start_date       = $start_date ?? date('Y-m-01');
 $end_date         = $end_date ?? date('Y-m-t');
 $total_pendapatan = $total_pendapatan ?? 0;
 $laporan          = $laporan ?? [];
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Laporan Transaksi Laundry</h4>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-secondary"><?= count($laporan) ?> transaksi</span>
            <a href="index.php?page=laporan&action=print&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" target="_blank" class="btn btn-sm btn-primary-custom" style="text-decoration:none;">
                <i class="fas fa-print me-1"></i> Cetak Laporan
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <span><strong>Total Pendapatan Periode:</strong> Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></span>
            <small class="text-muted"><?= $start_date ?> s/d <?= $end_date ?></small>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Outlet</th>
                        <th>Total Paket</th>
                        <th>Tambahan</th>
                        <th>Diskon</th>
                        <th>Final</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($laporan) > 0): ?>
                        <?php foreach ($laporan as $row): ?>
                        <?php
                            $invoice   = $row['kode_invoice'] ?? '-';
                            $tanggal   = $row['tanggal'] ?? '-';
                            $pelanggan = $row['member_name'] ?? '-';
                            $outlet    = $row['outlet_name'] ?? '-';
                            
                            $totalPaket    = (float) ($row['total_paket'] ?? 0);
                            $biayaTambahan = (float) ($row['biaya_tambahan'] ?? 0);
                            $diskonPersen  = (float) ($row['diskon'] ?? 0);
                            $diskonRupiah  = $totalPaket * ($diskonPersen / 100);
                            $finalPrice    = ($totalPaket + $biayaTambahan) - $diskonRupiah;
                            
                            $status = $row['status'] ?? '-';
                            if ($status === 'baru') $status = '<span class="badge bg-info">Baru</span>';
                            elseif ($status === 'proses') $status = '<span class="badge bg-warning text-dark">Proses</span>';
                            elseif ($status === 'selesai') $status = '<span class="badge bg-success">Selesai</span>';
                            elseif ($status === 'diambil') $status = '<span class="badge bg-primary">Diambil</span>';
                            
                            $bayar = $row['dibayar'] ?? '-';
                            if ($bayar === 'dibayar' || $bayar === 'lunas') $bayar = '<span class="badge bg-success">Dibayar</span>';
                            elseif ($bayar === 'belum_dibayar' || $bayar === 'belum') $bayar = '<span class="badge bg-danger">Belum</span>';
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($invoice) ?></strong></td>
                            <td><?= htmlspecialchars($tanggal) ?></td>
                            <td><?= htmlspecialchars($pelanggan) ?></td>
                            <td><?= htmlspecialchars($outlet) ?></td>
                            <td>Rp <?= number_format($totalPaket, 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($biayaTambahan, 0, ',', '.') ?></td>
                            <td><?= number_format($diskonPersen, 0, ',', '.') ?>%</td>
                            <td><strong>Rp <?= number_format($finalPrice, 0, ',', '.') ?></strong></td>
                            <td><?= $status ?></td>
                            <td><?= $bayar ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10" class="text-center">Tidak ada data transaksi</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>