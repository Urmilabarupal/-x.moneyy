<?php
/**
 * Database Configuration & Connection Gateway
 * File: C:\xampp\htdocs\x.money\BKD\26.10.00\db.php
 */

// 1. Database Credentials Configuration
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_NAME')) define('DB_NAME', 'x_money');
if (!defined('DB_PORT')) define('DB_PORT', 3306);
if (!defined('prefix'))  define('prefix', 'Coinx_');

// 2. Global Database Connection Instance
global $DB;

if (!isset($DB) || !$DB) {
    try {
        // Turn off default exception throwing to handle connection gracefully
        mysqli_report(MYSQLI_REPORT_OFF);

        // Attempt connection with configured database
        $DB = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        // Fallback without database selected if database is not created yet
        if (!$DB) {
            $DB = @mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        }

        // Set UTF-8 Character Set
        if ($DB) {
            mysqli_set_charset($DB, 'utf8mb4');
        }
    } catch (\Throwable $e) {
        $DB = null;
        error_log('Database Connection Error: ' . $e->getMessage());
    }
}

/**
 * Helper function to retrieve database connection instance
 */
if (!function_exists('getDB')) {
    function getDB() {
        global $DB;
        return $DB;
    }
}
?>
