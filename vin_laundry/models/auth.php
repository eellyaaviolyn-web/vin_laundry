<?php
namespace LaundryApp\Models;
use LaundryApp\Config\Database;
use LaundryApp\Helpers\Logger;
use PDO;
class Auth {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['outlet_id'] = $user['outlet_id'];
            Logger::log($user['id'], 'LOGIN', "User $email login");
            return true;
        }
        return false;
    }
    public function register($name, $email, $password, $role, $outlet_id) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO user (name, email, password, role, outlet_id) VALUES (?,?,?,?,?)");
        try {
            $stmt->execute([$name, $email, $hashed, $role, $outlet_id]);
            return true;
        } catch(\PDOException $e) { return false; }
    }
    public function logout() {
        if(isset($_SESSION['user_id'])) Logger::log($_SESSION['user_id'], 'LOGOUT', 'User logout');
        session_destroy();
    }
    public static function checkRole($allowedRoles) {
        if(!isset($_SESSION['user_id'])) { header('Location: index.php?page=login'); exit; }
        if(!in_array($_SESSION['user_role'], $allowedRoles)) { header('Location: index.php?page=dashboard'); exit; }
    }
}