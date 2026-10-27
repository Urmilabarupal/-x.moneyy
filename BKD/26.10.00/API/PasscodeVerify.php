<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
function passVerifyReply(int $status, int $success, string $message, $data = null): void {
    http_response_code($status); echo json_encode(['status_code'=>$status,'s'=>$success,'c'=>$data,'o'=>$message,'message'=>$message]); exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Allow: POST, OPTIONS'); passVerifyReply(405,0,'Use POST to verify a passcode.'); }
if (empty($_SESSION['wallet_verified']) || empty($_SESSION['user_id'])) passVerifyReply(401,0,'Verify wallet ownership before entering a passcode.');
$now=time();
if (!isset($_SESSION['passcode_attempts']) || !is_array($_SESSION['passcode_attempts'])) $_SESSION['passcode_attempts']=['count'=>0,'since'=>$now];
if ($now-(int)$_SESSION['passcode_attempts']['since'] > 900) $_SESSION['passcode_attempts']=['count'=>0,'since'=>$now];
if ((int)$_SESSION['passcode_attempts']['count'] >= 5) passVerifyReply(429,0,'Too many incorrect attempts. Wait 15 minutes and reconnect your wallet.');
$input=$_POST;
if (!$input) { $body=json_decode(file_get_contents('php://input') ?: '',true); if(is_array($body)) $input=$body; }
$pin=(string)($input['passcode'] ?? '');
if (!preg_match('/^\\d{4,8}$/',$pin)) passVerifyReply(422,0,'Enter a valid 4 to 8 digit passcode.');
$db=function_exists('getDB') ? getDB() : null;
if (!$db || !($db instanceof mysqli)) passVerifyReply(503,0,'Database is unavailable.');
$stmt=mysqli_prepare($db,'SELECT passcode_hash FROM Coinx_users WHERE ID = ? AND LOWER(wallet_address) = ? LIMIT 1');
if (!$stmt) passVerifyReply(503,0,'Apply the AURA auth migration before verifying a passcode.');
$userId=(int)$_SESSION['user_id']; $wallet=strtolower((string)$_SESSION['wallet_verified']);
mysqli_stmt_bind_param($stmt,'is',$userId,$wallet); mysqli_stmt_execute($stmt); mysqli_stmt_bind_result($stmt,$hash); $found=mysqli_stmt_fetch($stmt); mysqli_stmt_close($stmt);
if (!$found || !is_string($hash) || $hash === '') passVerifyReply(409,0,'No passcode is configured for this account.');
if (!password_verify($pin,$hash)) {
    $_SESSION['passcode_attempts']['count']=(int)$_SESSION['passcode_attempts']['count']+1;
    passVerifyReply(401,0,'Incorrect passcode.', ['attempts_remaining'=>max(0,5-(int)$_SESSION['passcode_attempts']['count'])]);
}
$_SESSION['passcode_attempts']=['count'=>0,'since'=>$now];
$_SESSION['passcode_verified']=true;
session_regenerate_id(true);
passVerifyReply(200,1,'Passcode verified. Session unlocked.',['verified'=>true,'user_id'=>(string)$userId]);
?>