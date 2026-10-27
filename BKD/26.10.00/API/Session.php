<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
function sessionReply(int $status, int $success, string $message, $data = null): void {
    http_response_code($status);
    echo json_encode(['status_code'=>$status,'s'=>$success,'c'=>$data,'o'=>$message,'message'=>$message], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'POST') {
    $input = $_POST;
    if (!$input) { $body=json_decode(file_get_contents('php://input') ?: '',true); if(is_array($body)) $input=$body; }
    $action = (string)($input['action'] ?? '');
    if ($action === 'lock') {
        $_SESSION['passcode_verified'] = false;
        session_regenerate_id(true);
        sessionReply(200,1,'Session locked.',['locked'=>true]);
    }
    if ($action === 'logout') {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], (bool)$params['secure'], (bool)$params['httponly']);
        }
        session_destroy();
        sessionReply(200,1,'Session ended.',['logged_out'=>true]);
    }
    sessionReply(422,0,'Unsupported session action.');
}
if ($method !== 'GET') { header('Allow: GET, POST, OPTIONS'); sessionReply(405,0,'Use GET to inspect or POST to lock/logout.'); }
if (empty($_SESSION['user_id']) || empty($_SESSION['wallet_verified'])) sessionReply(401,0,'No verified wallet session.');
$db=function_exists('getDB') ? getDB() : null;
if (!$db || !($db instanceof mysqli)) sessionReply(503,0,'Database is unavailable.');
$userId=(int)$_SESSION['user_id'];
$wallet=strtolower((string)$_SESSION['wallet_verified']);
$stmt=mysqli_prepare($db,'SELECT ID, userid, user_login, display_name, fname, lname, mobile, country, wallet_address, referby, user_registered, passcode_hash FROM Coinx_users WHERE ID = ? AND LOWER(wallet_address) = ? LIMIT 1');
if (!$stmt) sessionReply(503,0,'Apply the AURA auth migration before using sessions.');
mysqli_stmt_bind_param($stmt,'is',$userId,$wallet);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$id,$uid,$login,$displayName,$firstName,$lastName,$mobile,$country,$walletAddress,$referBy,$registered,$passcodeHash);
$found=mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if (!$found) { session_destroy(); sessionReply(401,0,'Account session is no longer valid.'); }
$configured=is_string($passcodeHash) && $passcodeHash !== '';
$_SESSION['passcode_configured']=$configured;
$unlocked=!empty($_SESSION['passcode_verified']) && $configured;
sessionReply(200,1,'Session inspected.',['authenticated'=>$unlocked,'locked'=>!$unlocked,'passcode_configured'=>$configured,'user'=>$unlocked ? [
    'id'=>(string)$id,'userid'=>(string)$uid,'username'=>(string)$login,'name'=>(string)$displayName,
    'fname'=>(string)$firstName,'lname'=>(string)$lastName,'mobile'=>(string)$mobile,
    'country'=>(string)$country,'wallet_address'=>(string)$walletAddress,
    'refer_by'=>(string)$referBy,'user_registered'=>(string)$registered
] : null]);
?>