<?php
/**
 * Create an account profile in Coinx_users.
 * Route: POST /x.money/?api=Register
 *
 * Requires the register_user_migration.sql schema migration.
 * Never accepts a user ID from the client and uses prepared SQL statements.
 */
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function registerResponse(int $httpStatus, int $success, string $message, $data = null): void {
    http_response_code($httpStatus);
    echo json_encode([
        'status_code' => $httpStatus,
        's' => $success,
        'c' => $data,
        'o' => $message,
        'message' => $message,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST, OPTIONS');
    registerResponse(405, 0, 'Use POST to register a new account.');
}

// index.php currently reflects arbitrary origins; restrict this write route separately.
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = array_filter(array_map('trim', explode(',', getenv('AURA_ALLOWED_ORIGINS') ?: 'https://aura-q5z5-one.vercel.app,http://localhost:3000,http://127.0.0.1:3000,http://localhost:5173,http://127.0.0.1:5173')));
if ($origin !== '' && !in_array($origin, $allowedOrigins, true)) {
    registerResponse(403, 0, 'This origin is not allowed to register accounts.');
}

$input = $_POST;
if (!$input) {
    $raw = file_get_contents('php://input');
    $decoded = json_decode($raw ?: '', true);
    if (is_array($decoded)) $input = $decoded;
}

$clean = static function ($value): string {
    return trim(strip_tags(is_scalar($value) ? (string)$value : ''));
};
$name = preg_replace('/\s+/', ' ', $clean($input['name'] ?? ''));
$country = $clean($input['country'] ?? '');
$mobile = $clean($input['mobile'] ?? '');
$walletAddress = $clean($input['wallet_address'] ?? $input['walletAddress'] ?? '');
$referId = $clean($input['refer_id'] ?? $input['referId'] ?? '');

if (strlen($name) < 2 || strlen($name) > 250) {
    registerResponse(422, 0, 'Enter a name between 2 and 250 characters.');
}
if ($country === '' || strlen($country) > 80) {
    registerResponse(422, 0, 'Choose a valid country.');
}
if (!preg_match('/^\d{10}$/', $mobile)) {
    registerResponse(422, 0, 'Enter a valid 10-digit mobile number.');
}
if (!preg_match('/^0x[a-fA-F0-9]{40}$/', $walletAddress)) {
    registerResponse(422, 0, 'Connect a valid EVM wallet address.');
}
if (strlen($referId) > 255) {
    registerResponse(422, 0, 'Referral ID is too long.');
}

$db = function_exists('getDB') ? getDB() : null;
if (!$db || !($db instanceof mysqli)) {
    error_log('AURA registration: database connection unavailable.');
    registerResponse(503, 0, 'Database is unavailable. Please try again later.');
}

$walletLower = strtolower($walletAddress);
// Account creation is permitted only after the backend verified a fresh MetaMask signature.
if (empty($_SESSION['wallet_verified']) || !is_string($_SESSION['wallet_verified']) || !hash_equals(strtolower($_SESSION['wallet_verified']), $walletLower)) {
    registerResponse(401, 0, 'Verify wallet ownership with the one-time signature challenge before registering.');
}
$check = mysqli_prepare($db, 'SELECT ID FROM Coinx_users WHERE wallet_address = ? LIMIT 1');
if (!$check) {
    error_log('AURA registration schema check failed: ' . mysqli_error($db));
    registerResponse(503, 0, 'Registration schema is not ready. Apply register_user_migration.sql first.');
}
mysqli_stmt_bind_param($check, 's', $walletLower);
mysqli_stmt_execute($check);
mysqli_stmt_bind_result($check, $existingId);
$exists = mysqli_stmt_fetch($check);
mysqli_stmt_close($check);
if ($exists) {
    registerResponse(409, 0, 'This wallet is already registered.', ['ID' => (string)$existingId]);
}

$parts = preg_split('/\s+/', $name, 2);
$firstName = $parts[0] ?? $name;
$lastName = $parts[1] ?? '';
$userLogin = 'mx_' . substr($walletLower, 2);
$userId = $walletLower;

$sql = 'INSERT INTO Coinx_users
    (user_login, userid, referby, user_nicename, display_name, fname, lname, mobile, country, wallet_address, user_registered, created, user_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 0)';
$stmt = mysqli_prepare($db, $sql);
if (!$stmt) {
    error_log('AURA registration insert prepare failed: ' . mysqli_error($db));
    registerResponse(503, 0, 'Registration schema is not ready. Apply register_user_migration.sql first.');
}
mysqli_stmt_bind_param($stmt, 'ssssssssss', $userLogin, $userId, $referId, $name, $name, $firstName, $lastName, $mobile, $country, $walletLower);
if (!mysqli_stmt_execute($stmt)) {
    $errorNo = mysqli_stmt_errno($stmt);
    error_log('AURA registration insert failed with MySQL error ' . $errorNo . '.');
    mysqli_stmt_close($stmt);
    if ($errorNo === 1062) registerResponse(409, 0, 'This wallet is already registered.');
    registerResponse(500, 0, 'Could not save the account to the database.');
}
$newId = mysqli_insert_id($db);
mysqli_stmt_close($stmt);
session_regenerate_id(true);
$_SESSION['user_id'] = (int)$newId;
$_SESSION['wallet_verified'] = $walletLower;
$_SESSION['passcode_verified'] = false;
$_SESSION['passcode_configured'] = false;

registerResponse(201, 1, 'Account registered in Coinx_users.', [
    'id' => (string)$newId,
    'ID' => (string)$newId,
    'userid' => $userId,
    'user_login' => $userLogin,
    'username' => $userLogin,
    'name' => $name,
    'display_name' => $name,
    'fname' => $firstName,
    'lname' => $lastName,
    'mobile' => $mobile,
    'country' => $country,
    'wallet_address' => $walletLower,
    'refer_by' => $referId,
    'user_registered' => date('Y-m-d H:i:s'),
]);
?>