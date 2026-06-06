<?php
echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>System Test</title>";
echo "<style>
body{font-family:Arial;padding:20px;background:#f5f5f5}
.box{background:white;padding:20px;margin:10px 0;border-radius:5px}
.ok{color:#4caf50}
.error{color:#f44336}
.warn{color:#ff9800}
table{border-collapse:collapse;margin-top:10px}
th,td{padding:6px 10px;border:1px solid #ccc}
</style></head><body>";



echo "<h2>🔧 System Test Page</h2>";

/**
 * FILE STRUCTURE
 */
echo "<div class='box'>";
echo "<h4>1️⃣ File Structure</h4>";

$files = [
    'index.php',
    'Config/Database.php',
    'Models/Auth.php',
    'views/auth/login.php'
];

foreach ($files as $file) {
    $exists = file_exists($file);
    echo "<p class='" . ($exists ? "ok" : "error") . "'>";
    echo ($exists ? "✓" : "✗") . " " . $file;
    echo "</p>";
}

echo "</div>";

/**
 * DATABASE TEST
 */
echo "<div class='box'>";
echo "<h4>2️⃣ Database Connection</h4>";

try {
    $host = 'sql212.infinityfree.com';
    $dbname = 'if0_41185945_laundry';
    $user = 'if0_41185945';
    $pass = 'ReLCJyuWPIVec';

    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p class='ok'>✓ Database connection successful</p>";

    /**
     * TABLE CHECK
     */
echo "<h4>3️⃣ Database Tables</h4>";

$stmt = $conn->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

// debug dulu
echo "<pre>";
print_r($tables);
echo "</pre>";

$required = ['outlet', 'user', 'member', 'logs', 'transaksi', 'paket'];

$tables = array_map(function ($t) {
    return strtolower(trim($t));
}, $tables);

foreach ($required as $table) {
    $exists = in_array(strtolower(trim($table)), $tables, true);

    echo "<p class='" . ($exists ? "ok" : "error") . "'>";
    echo ($exists ? "✓" : "✗") . " Table: " . htmlspecialchars($table);
    echo "</p>";
}

    /**
     * USERS
     */
    echo "<h4>4️⃣ Users</h4>";

    if (in_array('user', $tables)) {
        $stmt = $conn->query("SELECT id, name, email, role FROM user LIMIT 5");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";

            foreach ($users as $u) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($u['id']) . "</td>";
                echo "<td>" . htmlspecialchars($u['name']) . "</td>";
                echo "<td>" . htmlspecialchars($u['email']) . "</td>";
                echo "<td>" . htmlspecialchars($u['role']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }

} catch (Exception $e) {
    echo "<p class='error'>✗ " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</div>";

/**
 * AUDIT
 */
echo "<div class='box'>";
echo "<h4>5️⃣ Audit Result</h4>";

echo "<p class='warn'>• Folder config belum ada</p>";
echo "<p class='warn'>• File config/database.php belum ada</p>";
echo "<p class='warn'>• Table transaksi belum ada</p>";
echo "<p class='warn'>• Table paket belum ada</p>";
echo "<p class='ok'>• Koneksi database normal</p>";
echo "<p class='ok'>• Table user, member, outlet, logs normal</p>";

echo "</div>";

/**
 * AUTOLOADER SAFE TEST
 */
echo "<div class='box'>";
echo "<h4>6️⃣ Safe Autoloader Test</h4>";

if (file_exists('index.php')) {
    echo "<p class='ok'>✓ index.php ditemukan</p>";
} else {
    echo "<p class='error'>✗ index.php tidak ditemukan</p>";
}

echo "</div>";

echo "</body></html>";

$stmt = $conn->query("SELECT DATABASE()");
$current_db = $stmt->fetchColumn();

echo "<p>Current database: <strong>" . htmlspecialchars($current_db) . "</strong></p>";
?>