<?php
namespace LaundryApp\Models;

use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;
use PDOException;

class Outlet {
    private $db;
    public function __construct() { 
        $this->db = Database::getInstance()->getConnection(); 
    }
    
    public function getAll() { 
        $stmt = $this->db->query("SELECT * FROM outlet ORDER BY id DESC"); 
        return $stmt->fetchAll(); 
    }
    
    public function create($name, $address, $phone) {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("INSERT INTO outlet (name, address, phone) VALUES (?,?,?)");
            $stmt->execute([$name, $address, $phone]);
            $this->db->commit();
            Logger::log($_SESSION['user_id'], 'CREATE_OUTLET', "Outlet $name ditambahkan");
            return true;
        } catch(PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    public function update($id, $name, $address, $phone) {
        $stmt = $this->db->prepare("UPDATE outlet SET name=?, address=?, phone=? WHERE id=?");
        $result = $stmt->execute([$name, $address, $phone, $id]);
        if($result) Logger::log($_SESSION['user_id'], 'UPDATE_OUTLET', "Outlet ID $id diupdate");
        return $result;
    }
    
    public function delete($id) {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM outlet WHERE id=?");
            $stmt->execute([$id]);
            $this->db->commit();
            Logger::log($_SESSION['user_id'], 'DELETE_OUTLET', "Outlet ID $id dihapus");
            return true;
        } catch(PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    public function find($id) { 
        $stmt = $this->db->prepare("SELECT * FROM outlet WHERE id=?"); 
        $stmt->execute([$id]); 
        return $stmt->fetch(); 
    }
}