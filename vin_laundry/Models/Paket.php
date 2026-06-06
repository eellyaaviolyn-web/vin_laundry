<?php
namespace LaundryApp\Models;

use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;

class Paket {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($outlet_id = null) {
        if ($outlet_id) {
            $stmt = $this->db->prepare("SELECT * FROM paket WHERE outlet_id = ? ORDER BY id DESC");
            $stmt->execute([$outlet_id]);
        } else {
            $stmt = $this->db->query("SELECT p.*, o.name as outlet_name FROM paket p JOIN outlet o ON p.outlet_id = o.id ORDER BY p.id DESC");
        }
        return $stmt->fetchAll();
    }
    
    public function create($name, $price, $unit, $description, $outlet_id) {
        $stmt = $this->db->prepare("INSERT INTO paket (name, jenis, harga, deskripsi, outlet_id) VALUES (?,?,?,?,?)");
        $result = $stmt->execute([$name, $unit, $price, $description, $outlet_id]);
        if ($result) Logger::log($_SESSION['user_id'], 'CREATE_PAKET', "Paket $name ditambahkan");
        return $result;
    }
    
    public function update($id, $name, $price, $unit, $description, $outlet_id) {
        $stmt = $this->db->prepare("UPDATE paket SET name=?, jenis=?, harga=?, deskripsi=?, outlet_id=? WHERE id=?");
        $result = $stmt->execute([$name, $unit, $price, $description, $outlet_id, $id]);
        if ($result) Logger::log($_SESSION['user_id'], 'UPDATE_PAKET', "Paket ID $id diupdate");
        return $result;
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM paket WHERE id=?");
        $result = $stmt->execute([$id]);
        if ($result) Logger::log($_SESSION['user_id'], 'DELETE_PAKET', "Paket ID $id dihapus");
        return $result;
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM paket WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}