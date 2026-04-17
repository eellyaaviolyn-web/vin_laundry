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
            $stmt = $this->db->prepare("SELECT m.*, o.name as outlet_name FROM member m JOIN outlet o ON m.outlet_id = o.id WHERE m.outlet_id = ?");
            $stmt->execute([$outlet_id]);
        } else {
            $stmt = $this->db->query("SELECT m.*, o.name as outlet_name FROM member m JOIN outlet o ON m.outlet_id = o.id");
        }
        return $stmt->fetchAll();
    }
    
    public function create($name, $phone, $address, $email, $outlet_id) {
        $stmt = $this->db->prepare("INSERT INTO member (name, phone, address, email, outlet_id) VALUES (?,?,?,?,?)");
        $result = $stmt->execute([$name, $phone, $address, $email, $outlet_id]);
        if($result) Logger::log($_SESSION['user_id'], 'CREATE_MEMBER', "Member $name ditambahkan");
        return $result;
    }
    
    public function update($id, $name, $phone, $address, $email, $outlet_id) {
        $stmt = $this->db->prepare("UPDATE member SET name=?, phone=?, address=?, email=?, outlet_id=? WHERE id=?");
        $result = $stmt->execute([$name, $phone, $address, $email, $outlet_id, $id]);
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