<div class="card">
    <div class="card-header">
        <h3>Laporan Member per Outlet</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Outlet</th>
                    <th>Total Member</th>
                </tr>
            </thead>
            <tbody><?php foreach($reports as $r): ?><tr>
                    <td><?= $r['outlet_name'] ?></td>
                    <td><?= $r['total_member'] ?></td>
                </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</div>