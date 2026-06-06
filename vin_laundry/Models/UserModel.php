<?php
namespace LaundryApp\Models;

use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;

class UserModel {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getAll() { 
        $stmt = $this->db->query("SELECT u.*, o.name as outlet_name FROM user u JOIN outlet o ON u.outlet_id = o.id"); 
        return $stmt->fetchAll(); 
    }
    
    public function create($name, $email, $password, $role, $outlet_id) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO user (name, email, password, role, outlet_id) VALUES (?,?,?,?,?)");
        $result = $stmt->execute([$name, $email, $hashed, $role, $outlet_id]);
        if($result) Logger::log($_SESSION['user_id'], 'CREATE_USER', "User $email ditambahkan");
        return $result;
    }
    
    public function update($id, $name, $email, $role, $outlet_id, $password = null) {
        if($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE user SET name=?, email=?, password=?, role=?, outlet_id=? WHERE id=?");
            return $stmt->execute([$name, $email, $hashed, $role, $outlet_id, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE user SET name=?, email=?, role=?, outlet_id=? WHERE id=?");
            return $stmt->execute([$name, $email, $role, $outlet_id, $id]);
        }
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id=?");
        $result = $stmt->execute([$id]);
        if($result) Logger::log($_SESSION['user_id'], 'DELETE_USER', "User ID $id dihapus");
        return $result;
    }
    
    public function find($id) { $stmt = $this->db->prepare("SELECT * FROM user WHERE id=?"); $stmt->execute([$id]); return $stmt->fetch(); }
}