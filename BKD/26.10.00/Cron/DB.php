<?php
/**
 * Cron Job: Create Database if not exists
 * File: C:\xampp\htdocs\x.money\BKD\26.10.00\Cron\DB.php
 */

header('Content-Type: application/json; charset=UTF-8');

// Load DB configuration
require_once __DIR__ . '/../db.php';

$s = 0;
$echo = 'Failed';
$dbName = defined('DB_NAME') ? DB_NAME : 'x_money';
$host   = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
$user   = defined('DB_USER') ? DB_USER : 'root';
$pass   = defined('DB_PASS') ? DB_PASS : '';
$port   = defined('DB_PORT') ? DB_PORT : 3306;

try {
    mysqli_report(MYSQLI_REPORT_OFF);

    // Connect to MySQL server without selecting DB
    $conn = @mysqli_connect($host, $user, $pass, '', $port);

    if (!$conn) {
        $s = 0;
        $echo = 'MySQL Connection Error: ' . mysqli_connect_error();
        http_response_code(500);
    } else {
        // SQL query to create database if not exists
        $sql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $s = 1;
            $echo = "Database '{$dbName}' created or already exists successfully.";
            http_response_code(200);
        } else {
            $s = 0;
            $echo = 'Failed to create database: ' . mysqli_error($conn);
            http_response_code(500);
        }

        mysqli_close($conn);
    }
} catch (\Throwable $e) {
    $s = 0;
    $echo = 'Exception: ' . $e->getMessage();
    http_response_code(500);
}

$response = [
    's'           => $s,
    't'           => time(),
    'database'    => $dbName,
    'status_code' => http_response_code(),
    'message'     => $echo
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit();
?>
