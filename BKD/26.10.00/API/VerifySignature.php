<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function signatureReply(int $status, int $success, string $message, $data = null): void {
    http_response_code($status);
    echo json_encode(['status_code'=>$status,'s'=>$success,'c'=>$data,'o'=>$message,'message'=>$message], JSON_UNESCAPED_SLASHES);
    exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST, OPTIONS');
    signatureReply(405, 0, 'Use POST to verify a wallet signature.');
}
$input = $_POST;
if (!$input) { $body = json_decode(file_get_contents('php://input') ?: '', true); if (is_array($body)) $input = $body; }
$wallet = strtolower(trim((string)($input['wallet_address'] ?? $input['walletAddress'] ?? '')));
$signature = trim((string)($input['signature'] ?? ''));
$challenge = $_SESSION['aura_wallet_challenge'] ?? null;
if (!is_array($challenge) || empty($challenge['message']) || empty($challenge['expires']) || $challenge['expires'] < time()) {
    unset($_SESSION['aura_wallet_challenge']);
    signatureReply(401, 0, 'Wallet challenge expired. Request a new one.');
}
if (!preg_match('/^0x[a-f0-9]{40}$/', $wallet) || !hash_equals((string)$challenge['wallet'], $wallet)) signatureReply(422, 0, 'Wallet address does not match the challenge.');
if (!preg_match('/^0x[a-fA-F0-9]{130}$/', $signature)) signatureReply(422, 0, 'Signature format is invalid.');
$autoload = dirname(__DIR__, 3) . '/vendor/autoload.php';
if (!is_file($autoload)) signatureReply(503, 0, 'Wallet verification dependency is missing. Run composer install in the backend directory.');
require_once $autoload;
if (!extension_loaded('gmp') || !class_exists('Wmh\\EcRecover\\EcRecover')) signatureReply(503, 0, 'Server needs PHP GMP and wmh/php-ecrecover installed to verify wallet signatures.');
try {
    $recovered = strtolower(\\Wmh\\EcRecover\\EcRecover::personalRecover((string)$challenge['message'], $signature));
} catch (\\Throwable $e) {
    error_log('AURA signature recovery failed: '.$e->getMessage());
    signatureReply(401, 0, 'Wallet signature could not be verified.');
}
if (!hash_equals($wallet, $recovered)) signatureReply(401, 0, 'Wallet signature does not match the connected address.');
// Consume challenge before any database work: signatures cannot be replayed.
unset($_SESSION['aura_wallet_challenge']);
session_regenerate_id(true);
$_SESSION['wallet_verified'] = $wallet;
$_SESSION['passcode_verified'] = false;
$db = function_exists('getDB') ? getDB() : null;
if (!$db || !($db instanceof mysqli)) signatureReply(503, 0, 'Database is unavailable.');
$stmt = mysqli_prepare($db, 'SELECT ID, passcode_hash FROM Coinx_users WHERE wallet_address = ? LIMIT 1');
if (!$stmt) signatureReply(503, 0, 'Registration schema is not ready. Apply the AURA auth migration.');
mysqli_stmt_bind_param($stmt, 's', $wallet);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $userId, $passcodeHash);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if ($found) {
    $_SESSION['user_id'] = (int)$userId;
    $_SESSION['passcode_configured'] = is_string($passcodeHash) && $passcodeHash !== '';
    signatureReply(200, 1, 'Wallet ownership verified.', ['registered'=>true,'user_id'=>(string)$userId,'passcode_configured'=>$_SESSION['passcode_configured']]);
}
signatureReply(200, 1, 'Wallet ownership verified. Complete registration.', ['registered'=>false,'wallet_address'=>$wallet]);
?>