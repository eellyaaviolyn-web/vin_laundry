<?php
/**
 * Root Entry Point - Redirect semua traffic ke vin_laundry
 * Digunakan sebagai alternative jika .htaccess di root tidak bekerja
 */

// Jika akses langsung root atau path yang tidak ada
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove domain path prefix jika ada
$path = str_replace('/vin_laundry', '', $path);
$path = trim($path, '/');

// Handle direktly request to root
if ($path === '' || $path === 'index.php') {
    header('Location: /vin_laundry/');
    exit;
}

// Include vin_laundry/index.php dengan parameter yang sesuai
$_GET['page'] = $path;
require 'vin_laundry/index.php';
?>
