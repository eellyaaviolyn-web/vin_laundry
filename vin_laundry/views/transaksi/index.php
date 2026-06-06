<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-receipt me-2"></i> Transaksi</h3>
    <a href="?page=transaksi&action=create" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>
</div>

<?php if(isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Outlet</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bayar</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($transaksis)): ?>
                    <?php foreach($transaksis as $t): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($t['kode_invoice']) ?></code></td>
                        <td><strong><?= htmlspecialchars($t['member_name']) ?></strong></td>
                        <td><?= htmlspecialchars($t['outlet_name']) ?></td>
                        <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                        <td><strong>Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></strong></td>
                        <td>
                            <?php
                            $badge = ['baru'=>'bg-secondary','proses'=>'bg-info text-dark','selesai'=>'bg-success','diambil'=>'bg-primary'];
                            ?>
                            <span class="badge <?= $badge[$t['status']] ?? 'bg-secondary' ?>"><?= ucfirst($t['status']) ?></span>
                        </td>
                        <td>
                            <?php if($t['dibayar'] === 'lunas'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 180px;">
                                    <li>
                                        <a class="dropdown-item" href="?page=transaksi&action=print&id=<?= $t['id'] ?>" target="_blank">
                                            <i class="fas fa-print text-primary me-2"></i> Cetak
                                        </a>
                                    </li>
                                    <!-- UBAH STATUS LAUNDRY -->
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-header text-muted" style="font-size:11px;">Status Laundry</li>
                                    <?php if($t['status'] == 'baru'): ?>
                                    <li><a class="dropdown-item" href="?page=transaksi&action=status&id=<?= $t['id'] ?>&status=proses"><i class="fas fa-spinner text-info me-2"></i> Proses</a></li>
                                    <?php endif; ?>
                                    <?php if($t['status'] == 'proses'): ?>
                                    <li><a class="dropdown-item" href="?page=transaksi&action=status&id=<?= $t['id'] ?>&status=selesai"><i class="fas fa-check text-success me-2"></i> Selesai</a></li>
                                    <?php endif; ?>
                                    <?php if($t['status'] == 'selesai'): ?>
                                    <li><a class="dropdown-item" href="?page=transaksi&action=status&id=<?= $t['id'] ?>&status=diambil"><i class="fas fa-box-open text-primary me-2"></i> Diambil</a></li>
                                    <?php endif; ?>
                                    
                                    <!-- UBAH STATUS BAYAR -->
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-header text-muted" style="font-size:11px;">Status Pembayaran</li>
                                    <?php if($t['dibayar'] == 'belum_bayar'): ?>
                                    <li><a class="dropdown-item text-success fw-bold" href="?page=transaksi&action=status&id=<?= $t['id'] ?>&status=<?= $t['status'] ?>&payment=lunas"><i class="fas fa-money-bill-wave me-2"></i> Tandai Lunas</a></li>
                                    <?php else: ?>
                                    <li><a class="dropdown-item text-warning" href="?page=transaksi&action=status&id=<?= $t['id'] ?>&status=<?= $t['status'] ?>&payment=belum_bayar"><i class="fas fa-undo me-2"></i> Batal Bayar</a></li>
                                    <?php endif; ?>

                                    <!-- EDIT & HAPUS -->
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="?page=transaksi&action=edit&id=<?= $t['id'] ?>"><i class="fas fa-edit text-warning me-2"></i> Edit</a></li>
                                    <li><a class="dropdown-item text-danger" href="?page=transaksi&action=delete&id=<?= $t['id'] ?>" onclick="return confirm('Hapus transaksi ini?')"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data transaksi.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>