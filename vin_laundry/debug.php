<?php
/**
 * Debug Logger Viewer
 * Lihat file: vin_laundry/debug.php untuk melihat error log
 */

// Get error log file
$error_log_file = ini_get('error_log');
$debug_log_file = __DIR__ . '/logs/debug.log';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Logger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; padding: 2rem; }
        .debug-box { background: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem; }
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: 6px; overflow-x: auto; }
        code { color: #ce9178; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">🔧 DEBUG LOGGER</h2>
        
        <div class="debug-box">
            <h5>📋 PHP Error Log</h5>
            <p class="text-muted small">Location: <?= htmlspecialchars($error_log_file ?: 'Not configured') ?></p>
            <pre><?php
            if ($error_log_file && file_exists($error_log_file)) {
                $lines = file($error_log_file);
                $last_lines = array_slice($lines, -50); // Last 50 lines
                echo htmlspecialchars(implode('', $last_lines)) ?: 'No log entries yet';
            } else {
                echo 'Error log file not found or not configured';
            }
            ?></pre>
        </div>
        
        <div class="debug-box">
            <h5>📊 Login Test Accounts</h5>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>admin@laundry.local</code></td>
                        <td><code>admin123</code></td>
                        <td>admin</td>
                    </tr>
                    <tr>
                        <td><code>operator1@laundry.local</code></td>
                        <td><code>operator123</code></td>
                        <td>operator</td>
                    </tr>
                    <tr>
                        <td><code>operator2@laundry.local</code></td>
                        <td><code>operator123</code></td>
                        <td>operator</td>
                    </tr>
                    <tr>
                        <td><code>manager1@laundry.local</code></td>
                        <td><code>manager123</code></td>
                        <td>manager</td>
                    </tr>
                    <tr>
                        <td><code>admin@admin</code></td>
                        <td><code>admin</code></td>
                        <td>admin</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="debug-box">
            <h5>🔄 Auto Refresh</h5>
            <button class="btn btn-primary btn-sm" onclick="location.reload()">Refresh Log</button>
            <a href="index.php?page=login" class="btn btn-secondary btn-sm">Back to Login</a>
        </div>
    </div>
    
    <script>
        // Auto refresh every 2 seconds
        // setInterval(() => location.reload(), 2000);
    </script>
</body>
</html>
