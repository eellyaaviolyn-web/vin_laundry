<?php

class LaporanModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getLaporan($start_date, $end_date)
    {
        $sql = "SELECT 
                    t.id,
                    t.kode_invoice,
                    t.tanggal,
                    t.batas_waktu,
                    t.biaya_tambahan,
                    t.diskon,
                    t.status,
                    t.dibayar,
                    m.name AS member_name,
                    o.name AS outlet_name,
                    COALESCE(d.total_paket, 0) AS total_paket
                FROM transaksi t
                LEFT JOIN member m ON t.member_id = m.id
                LEFT JOIN outlet o ON t.outlet_id = o.id
                LEFT JOIN (
                    SELECT transaksii_id, SUM(subtotal) AS total_paket
                    FROM detail_transaksi
                    GROUP BY transaksii_id
                ) d ON t.id = d.transaksii_id
                WHERE t.tanggal BETWEEN :start_date AND :end_date
                ORDER BY t.tanggal DESC, t.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':start_date' => $start_date,
            ':end_date'   => $end_date
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPendapatan($start_date, $end_date)
    {
        $sql = "SELECT COALESCE(SUM(
                    COALESCE(d.total_paket, 0) + COALESCE(t.biaya_tambahan, 0) - COALESCE(t.diskon, 0)
                ), 0) AS total
                FROM transaksi t
                LEFT JOIN (
                    SELECT transaksii_id, SUM(subtotal) AS total_paket
                    FROM detail_transaksi
                    GROUP BY transaksii_id
                ) d ON t.id = d.transaksii_id
                WHERE t.tanggal BETWEEN :start_date AND :end_date
                AND t.status = 'diambil'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':start_date' => $start_date,
            ':end_date'   => $end_date
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total'] ?? 0);
    }
}