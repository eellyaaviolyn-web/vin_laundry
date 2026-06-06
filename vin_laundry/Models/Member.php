<?php
namespace LaundryApp\Models;

use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;

class Member {
    private $db;
    
    public function __construct() { 
        $this->db = Database::getInstance()->getConnection(); 
    }
    
    public function getAll($outlet_id = null) {
        if($outlet_id) {
            $stmt = $this->db->prepare("SELECT id, name, address, jenis_kelamin, phone, outlet_id FROM member WHERE outlet_id = ? ORDER BY name ASC");
            $stmt->execute([$outlet_id]);
        } else {
            $stmt = $this->db->query("SELECT id, name, address, jenis_kelamin, phone, outlet_id FROM member ORDER BY name ASC");
        }
        return $stmt->fetchAll();
    }
    
    public function create($nama, $telp, $alamat, $jenis_kelamin, $outlet_id) {
        $stmt = $this->db->prepare("INSERT INTO member (name, phone, address, jenis_kelamin, outlet_id) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$nama, $telp, $alamat, $jenis_kelamin, $outlet_id]);
        if($result) Logger::log($_SESSION['user_id'], 'CREATE_MEMBER', "Member $nama ditambahkan");
        return $result;
    }
    
    public function update($id, $nama, $telp, $alamat, $jenis_kelamin, $outlet_id) {
        $stmt = $this->db->prepare("UPDATE member SET name=?, phone=?, address=?, jenis_kelamin=?, outlet_id=? WHERE id=?");
        $result = $stmt->execute([$nama, $telp, $alamat, $jenis_kelamin, $outlet_id, $id]);
        if($result) Logger::log($_SESSION['user_id'], 'UPDATE_MEMBER', "Member ID $id diupdate");
        return $result;
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM member WHERE id=?");
        $result = $stmt->execute([$id]);
        if($result) Logger::log($_SESSION['user_id'], 'DELETE_MEMBER', "Member ID $id dihapus");
        return $result;
    }
    
    public function find($id) { 
        $stmt = $this->db->prepare("SELECT * FROM member WHERE id=?"); 
        $stmt->execute([$id]); 
        return $stmt->fetch(); 
    }
}