<?php
/**
 * Cron Job: Execute all SQL files in SQL folder to create tables in Database
 * File: C:\xampp\htdocs\x.money\BKD\26.10.00\Cron\TableNew.php
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

$sqlDir = realpath(__DIR__ . '/../SQL');

$createdTables = [];
$failedTables  = [];

try {
    mysqli_report(MYSQLI_REPORT_OFF);

    // 1. Connect to MySQL Server
    $conn = @mysqli_connect($host, $user, $pass, '', $port);

    if (!$conn) {
        http_response_code(500);
        echo json_encode([
            's'           => 0,
            'status_code' => 500,
            'message'     => 'Cannot connect to MySQL server: ' . mysqli_connect_error()
        ]);
        exit();
    }

    // 2. Ensure Database exists and select it
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    if (!mysqli_select_db($conn, $dbName)) {
        http_response_code(500);
        echo json_encode([
            's'           => 0,
            'status_code' => 500,
            'message'     => "Cannot select database '{$dbName}': " . mysqli_error($conn)
        ]);
        mysqli_close($conn);
        exit();
    }

    // 3. Scan SQL folder for .sql files
    if (!$sqlDir || !is_dir($sqlDir)) {
        http_response_code(404);
        echo json_encode([
            's'           => 0,
            'status_code' => 404,
            'message'     => "SQL directory not found."
        ]);
        mysqli_close($conn);
        exit();
    }

    $sqlFiles = glob($sqlDir . '/*.sql');

    foreach ($sqlFiles as $file) {
        $tableName = basename($file, '.sql');
        $sqlContent = file_get_contents($file);

        if (!empty($sqlContent)) {
            // Execute multi query or single query
            if (mysqli_multi_query($conn, $sqlContent)) {
                do {
                    // Flush multi_query results
                    if ($result = mysqli_store_result($conn)) {
                        mysqli_free_result($result);
                    }
                } while (mysqli_more_results($conn) && mysqli_next_result($conn));

                $createdTables[] = $tableName;
            } else {
                $failedTables[$tableName] = mysqli_error($conn);
            }
        }
    }

    mysqli_close($conn);

    if (empty($failedTables) && !empty($createdTables)) {
        $s = 1;
        $echo = "All tables created successfully in database '{$dbName}'.";
        http_response_code(200);
    } elseif (!empty($createdTables)) {
        $s = 1;
        $echo = "Some tables created with warnings in database '{$dbName}'.";
        http_response_code(200);
    } else {
        $s = 0;
        $echo = "No tables were created.";
        http_response_code(500);
    }

} catch (\Throwable $e) {
    $s = 0;
    $echo = 'Exception: ' . $e->getMessage();
    http_response_code(500);
}

$response = [
    's'              => $s,
    't'              => time(),
    'database'       => $dbName,
    'status_code'    => http_response_code(),
    'message'        => $echo,
    'total_files'    => count($sqlFiles),
    'created_count'  => count($createdTables),
    'created_tables' => $createdTables,
    'failed_tables'  => $failedTables
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit();
?>
