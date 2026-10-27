<?php
/**
 * Global Bootstrap & Framework Loader for x.money
 * File: C:\xampp\htdocs\x.money\BKD\26.10.00\bootstrap.php
 */

// 1. Secure PHP session cookie defaults.
// Localhost remains HTTP-compatible for XAMPP; HTTPS deployments use Secure cookies.
// Set AURA_SESSION_SAMESITE=None for a separate-site HTTPS frontend/backend pair.
if (session_status() === PHP_SESSION_NONE) {
    $requestIsHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $sameSite = getenv('AURA_SESSION_SAMESITE') ?: ($requestIsHttps ? 'None' : 'Lax');
    if (!in_array($sameSite, ['Lax','Strict','None'], true)) $sameSite = 'Lax';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $requestIsHttps,
        'httponly' => true,
        'samesite' => $sameSite,
    ]);
    session_start();
}

// 2. Framework Constants & Configuration
if (!defined('prefix')) {
    define('prefix', 'Coinx_');
}

if (!defined('Setting')) {
    define('Setting', [
        'launched'   => 1,
        'launch'     => 1,
        'sitename'   => 'x.money',
        'domain'     => 'x.money',
        'api_version'=> '26.10.00'
    ]);
}

// Auth identity comes only from the server-side session.
// Never treat a caller-controlled ?user= parameter as authentication.
if (!defined('i')) {
    $currentUserId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    define('i', [
        'id'       => $currentUserId,
        'Role'     => isset($_SESSION['role']) ? $_SESSION['role'] : 'User',
        'Passcode' => !empty($_SESSION['passcode_verified']) ? 1 : 0
    ]);
}

// 3. Helper Functions & Utilities via dedicated tools.php
require_once __DIR__ . '/tools.php';

// 4. Database Connection ($DB) via dedicated db.php
require_once __DIR__ . '/db.php';

// 5. Load Alien Framework Core Engine
require_once __DIR__ . '/system.php';

// 6. Automatically Load All Module Files (CRUD Functions)
$moduleDir = __DIR__ . '/SDK/Module/';
if (is_dir($moduleDir)) {
    foreach (glob($moduleDir . '*.php') as $moduleFile) {
        require_once $moduleFile;
    }
}
?>
