<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
function passSetupReply(int $status, int $success, string $message, $data = null): void {
    http_response_code($status); echo json_encode(['status_code'=>$status,'s'=>$success,'c'=>$data,'o'=>$message,'message'=>$message]); exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Allow: POST, OPTIONS'); passSetupReply(405,0,'Use POST to set a passcode.'); }
if (empty($_SESSION['wallet_verified']) || empty($_SESSION['user_id'])) passSetupReply(401,0,'Verify wallet ownership before setting a passcode.');
$input = $_POST;
if (!$input) { $body=json_decode(file_get_contents('php://input') ?: '',true); if(is_array($body)) $input=$body; }
$pin = (string)($input['passcode'] ?? '');
if (!preg_match('/^\\d{6}$/', $pin)) passSetupReply(422,0,'Passcode must contain 4 to 8 digits.');
$db = function_exists('getDB') ? getDB() : null;
if (!$db || !($db instanceof mysqli)) passSetupReply(503,0,'Database is unavailable.');
$hash = password_hash($pin, PASSWORD_DEFAULT);
if (!$hash) passSetupReply(500,0,'Could not secure the passcode.');
$stmt = mysqli_prepare($db, 'UPDATE Coinx_users SET passcode_hash = ? WHERE ID = ? AND LOWER(wallet_address) = ?');
if (!$stmt) passSetupReply(503,0,'Apply the AURA auth migration before setting a passcode.');
$userId=(int)$_SESSION['user_id']; $wallet=strtolower((string)$_SESSION['wallet_verified']);
mysqli_stmt_bind_param($stmt,'sis',$hash,$userId,$wallet);
$ok=mysqli_stmt_execute($stmt); $affected=mysqli_stmt_affected_rows($stmt); mysqli_stmt_close($stmt);
if (!$ok) passSetupReply(500,0,'Could not save the passcode.');
$check = mysqli_prepare($db, 'SELECT ID FROM Coinx_users WHERE ID = ? AND LOWER(wallet_address) = ? LIMIT 1');
if (!$check) passSetupReply(503,0,'Could not confirm the account after saving the passcode.');
mysqli_stmt_bind_param($check,'is',$userId,$wallet);
mysqli_stmt_execute($check);
mysqli_stmt_bind_result($check,$confirmedId);
$confirmed = mysqli_stmt_fetch($check);
mysqli_stmt_close($check);
if (!$confirmed) passSetupReply(401,0,'Account session is no longer valid.');
// A repeated identical hash may report 0 affected rows, so confirm the account still exists.
$_SESSION['passcode_configured']=true;
$_SESSION['passcode_verified']=false;
session_regenerate_id(true);
passSetupReply(200,1,'Passcode saved securely. Enter it on the lock screen to unlock.',['configured'=>true]);
?>