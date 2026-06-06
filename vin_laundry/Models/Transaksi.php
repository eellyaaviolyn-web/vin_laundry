<?php
namespace LaundryApp\Models;

use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;

class Transaksi {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($outlet_id = null) {
        if ($outlet_id) {
            $stmt = $this->db->prepare("SELECT t.*, m.name as member_name, o.name as outlet_name FROM transaksi t JOIN member m ON t.member_id = m.id JOIN outlet o ON t.outlet_id = o.id WHERE t.outlet_id = ? ORDER BY t.id DESC");
            $stmt->execute([$outlet_id]);
        } else {
            $stmt = $this->db->query("SELECT t.*, m.name as member_name, o.name as outlet_name FROM transaksi t JOIN member m ON t.member_id = m.id JOIN outlet o ON t.outlet_id = o.id ORDER BY t.id DESC");
        }
        return $stmt->fetchAll();
    }
    
    public function findWithDetails($id) {
        $stmt = $this->db->prepare("
            SELECT t.*, m.name as member_name, m.phone as member_phone, o.name as outlet_name, o.phone as outlet_phone, o.address as outlet_address
            FROM transaksi t 
            JOIN member m ON t.member_id = m.id 
            JOIN outlet o ON t.outlet_id = o.id 
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        $tx = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($tx) {
            $stmtD = $this->db->prepare("
                SELECT dt.*, p.name as paket_name 
                FROM detail_transaksi dt 
                JOIN paket p ON dt.paket_id = p.id 
                WHERE dt.transaksi_id = ?
            ");
            $stmtD->execute([$id]);
            $tx['details'] = $stmtD->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $tx;
    }

    public function create($data) {
        try {
            $this->db->beginTransaction();
            $outlet_id = $data['outlet_id'] ?? $_SESSION['outlet_id'] ?? null;
            $tanggal = $data['tgl_pembelian'] ?? $data['tanggal'] ?? date('Y-m-d');
            $batas_waktu = $data['batas_waktu'] ?? date('Y-m-d', strtotime('+3 days'));
            $diskon_persen = $data['diskon'] ?? 0;
            $pajak = $data['pajak'] ?? 0;
            $biaya_tambahan = $data['biaya_tambahan'] ?? 0;

            if (!$outlet_id) throw new \Exception("Outlet tidak ditemukan.");

            $tgl = date('Ymd', strtotime($tanggal));
            
            $stmt = $this->db->prepare("SELECT MAX(CAST(RIGHT(kode_invoice, 3) AS UNSIGNED)) AS max_nomor FROM transaksi WHERE kode_invoice LIKE ?");
            $stmt->execute(['INV-' . $tgl . '-%']);
            $maxNomor = $stmt->fetch(PDO::FETCH_ASSOC)['max_nomor'];
            $nomor = ($maxNomor ? intval($maxNomor) : 0) + 1;
            
            $duplikat = true;
            while ($duplikat) {
                $kode_invoice = 'INV-' . $tgl . '-' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
                $cek = $this->db->prepare("SELECT COUNT(*) FROM transaksi WHERE kode_invoice = ?");
                $cek->execute([$kode_invoice]);
                $duplikat = $cek->fetchColumn() > 0;
                if ($duplikat) $nomor++;
            }

            $stmt = $this->db->prepare("INSERT INTO transaksi (outlet_id, member_id, user_id, kode_invoice, tanggal, batas_waktu, biaya_tambahan, diskon, pajak, total_biaya, status, dibayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'baru', 'belum_bayar')");
            $stmt->execute([$outlet_id, $data['member_id'], $_SESSION['user_id'], $kode_invoice, $tanggal, $batas_waktu, $biaya_tambahan, $diskon_persen, $pajak]);
            $transaksi_id = $this->db->lastInsertId();

            $this->insertDetails($transaksi_id, $data);
            $this->hitungTotal($transaksi_id, $diskon_persen);

            $this->db->commit();
            return $kode_invoice;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function update($id, $data) {
        try {
            $this->db->beginTransaction();
            $diskon_persen = $data['diskon'] ?? 0;
            $pajak = $data['pajak'] ?? 0;
            $biaya_tambahan = $data['biaya_tambahan'] ?? 0;

            $stmt = $this->db->prepare("UPDATE transaksi SET member_id = ?, biaya_tambahan = ?, diskon = ?, pajak = ?, total_biaya = 0 WHERE id = ?");
            $stmt->execute([$data['member_id'], $biaya_tambahan, $diskon_persen, $pajak, $id]);

            $stmtDel = $this->db->prepare("DELETE FROM detail_transaksi WHERE transaksi_id = ?");
            $stmtDel->execute([$id]);

            $this->insertDetails($id, $data);
            $this->hitungTotal($id, $diskon_persen);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    private function insertDetails($transaksi_id, $data) {
        $pakets = $data['paket_id'] ?? [];
        $qtys = $data['qty'] ?? [];
        foreach ($pakets as $i => $paket_id) {
            if (empty($paket_id) || empty($qtys[$i]) || $qtys[$i] <= 0) continue;
            $qty = $qtys[$i];
            $stmtP = $this->db->prepare("SELECT harga FROM paket WHERE id = ?");
            $stmtP->execute([$paket_id]);
            $harga = $stmtP->fetch(PDO::FETCH_ASSOC)['harga'];
            $subtotal = $qty * $harga;
            $stmtD = $this->db->prepare("INSERT INTO detail_transaksi (transaksi_id, paket_id, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmtD->execute([$transaksi_id, $paket_id, $qty, $harga, $subtotal]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM transaksi WHERE id = ?");
        $result = $stmt->execute([$id]);
        if ($result) Logger::log($_SESSION['user_id'], 'DELETE_TRANSAKSI', "Transaksi ID $id dihapus");
        return $result;
    }

    private function hitungTotal($transaksi_id, $diskon_persen = 0) {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(subtotal), 0) AS subtotal FROM detail_transaksi WHERE transaksi_id = ?");
        $stmt->execute([$transaksi_id]);
        $subtotal = $stmt->fetch(PDO::FETCH_ASSOC)['subtotal'];

        $stmt = $this->db->prepare("SELECT biaya_tambahan, pajak FROM transaksi WHERE id = ?");
        $stmt->execute([$transaksi_id]);
        $extra = $stmt->fetch(PDO::FETCH_ASSOC);

        $diskon_rupiah = $subtotal * ($diskon_persen / 100);
        $total = $subtotal + ($extra['biaya_tambahan'] ?? 0) - $diskon_rupiah + ($extra['pajak'] ?? 0);

        $stmtUp = $this->db->prepare("UPDATE transaksi SET total_biaya = ? WHERE id = ?");
        $stmtUp->execute([$total, $transaksi_id]);
    }
    
    public function updateStatus($id, $status, $payment_status = null) {
        $sql = "UPDATE transaksi SET status = ?";
        $params = [$status];
        if ($payment_status) { $sql .= ", dibayar = ?"; $params[] = $payment_status; }
        $sql .= " WHERE id = ?"; $params[] = $id;
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($params);
        if ($result) Logger::log($_SESSION['user_id'], 'UPDATE_TRANSAKSI', "Transaksi ID $id status diubah");
        return $result;
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}