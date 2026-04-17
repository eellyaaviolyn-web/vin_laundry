<?php
namespace LaundryApp\Helpers;
use LaundryApp\Config\Database;
class Logger {
    public static function log($user_id, $action, $description) {
        $db = Database::getInstance()->getConnection();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = $db->prepare("INSERT INTO logs (user_id, action, description, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $action, $description, $ip]);
    }
}