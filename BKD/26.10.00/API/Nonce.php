<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function nonceReply(int $status, int $success, string $message, $data = null): void {
    http_response_code($status);
    echo json_encode(['status_code'=>$status,'s'=>$success,'c'=>$data,'o'=>$message,'message'=>$message], JSON_UNESCAPED_SLASHES);
    exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST, OPTIONS');
    nonceReply(405, 0, 'Use POST to request a wallet challenge.');
}
$input = $_POST;
if (!$input) { $body = json_decode(file_get_contents('php://input') ?: '', true); if (is_array($body)) $input = $body; }
$wallet = strtolower(trim((string)($input['wallet_address'] ?? $input['walletAddress'] ?? '')));
if (!preg_match('/^0x[a-f0-9]{40}$/', $wallet)) nonceReply(422, 0, 'A valid EVM wallet address is required.');
if (!function_exists('random_bytes')) nonceReply(503, 0, 'Secure random generator unavailable.');
$nonce = bin2hex(random_bytes(32));
$challenge = "AURA wallet verification\nWallet: {$wallet}\nNonce: {$nonce}\nIssued: ".gmdate('c')."\nThis signature only proves wallet ownership; it does not authorize a blockchain transaction.";
$_SESSION['aura_wallet_challenge'] = ['wallet'=>$wallet,'nonce'=>$nonce,'message'=>$challenge,'expires'=>time()+300];
unset($_SESSION['wallet_verified'], $_SESSION['passcode_verified'], $_SESSION['user_id']);
session_regenerate_id(true);
nonceReply(200, 1, 'Wallet challenge created.', ['wallet_address'=>$wallet,'message'=>$challenge,'expires_in'=>300]);
?>