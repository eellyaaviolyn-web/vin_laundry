<?php
namespace LaundryApp\Config;
use PDO;
use PDOException;
class Database {
    private static $instance = null;
    private $conn;
    private function __construct() {
        $host = 'sql100.infinityfree.com';
        $dbname = 'if0_41544758_db_laundry';
        $user = 'if0_41544758';
        $pass = '2vuaNGNuK10R2';
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            ob_end_clean();
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Database Error</title>
                <style>
                    body { font-family: Arial; padding: 20px; background: #f5f5f5; }
                    .box { background: white; padding: 20px; border-radius: 5px; max-width: 600px; margin: 50px auto; }
                    h3 { color: #d32f2f; }
                    code { background: #f5f5f5; padding: 2px 5px; border-radius: 3px; }
                    a { color: #1976d2; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="box">
                    <h3>🔴 Database Connection Error</h3>
                    <p><strong>Error:</strong> <?= htmlspecialchars($e->getMessage()) ?></p>
                    <p><strong>Host:</strong> <code><?= htmlspecialchars($host) ?></code></p>
                    <p><strong>Database:</strong> <code><?= htmlspecialchars($dbname) ?></code></p>
                    <p><strong>User:</strong> <code><?= htmlspecialchars($user) ?></code></p>
                    <hr>
                    <h4>Langkah untuk memperbaiki:</h4>
                    <ol>
                        <li>Pastikan MySQL/MariaDB running</li>
                        <li>Pastikan database <code><?= htmlspecialchars($dbname) ?></code> sudah dibuat</li>
                        <li>Import file <code>database.sql</code> ke database</li>
                        <li>Cek username/password di <code>config/database.php</code></li>
                    </ol>
                    <p><a href="test.php">← Kembali ke System Test</a></p>
                </div>
            </body>
            </html>
            <?php
            exit;
        }
    }
    public static function getInstance() {
        if (self::$instance == null) self::$instance = new Database();
        return self::$instance;
    }
    public function getConnection() { return $this->conn; }
}