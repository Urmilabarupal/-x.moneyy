<?php
/**
 * Root Security Gateway & Central API Router
 * Location: C:\xampp\htdocs\x.money\index.php
 *
 * Supports API Dispatching:
 * https://localhost/x.money/?api=User
 * https://localhost/x.money/?api=UserNew
 * https://localhost/x.money/?api=Users
 * https://localhost/x.money/?api=Deposit
 * https://localhost/x.money/?api=Withdraw
 */

// 1. Force HTTPS Protocol on production (skip on local environment)
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', '::1']);
if (
    !$isLocal &&
    (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') &&
    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https' : true) &&
    ($_SERVER['SERVER_PORT'] !== 443)
) {
    $redirectUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirectUrl, true, 301);
    exit();
}

// 2. Global Security Headers & CORS
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = array_filter(array_map('trim', explode(',', getenv('AURA_ALLOWED_ORIGINS') ?: 'https://aura-q5z5-one.vercel.app,http://localhost:3000,http://127.0.0.1:3000,http://localhost:5173,http://127.0.0.1:5173')));
if ($origin !== '' && !in_array($origin, $allowedOrigins, true)) {
    http_response_code(403);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['status_code'=>403,'s'=>0,'o'=>'Origin is not allowed.']);
    exit();
}
if ($origin !== '') {
    header("Access-Control-Allow-Origin: {$origin}");
    header('Vary: Origin');
    header('Access-Control-Allow-Credentials: true');
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-Idempotency-Key');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// 3. Security Check: Block direct public access to sensitive file extensions & database folders
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$blockedExtensions = ['sql', 'env', 'log', 'ini', 'bak', 'conf', 'sh', 'git', 'md', 'jsonl'];
$fileExtension = strtolower(pathinfo($requestUri, PATHINFO_EXTENSION));

if (in_array($fileExtension, $blockedExtensions) || preg_match('#/SQL/#i', $requestUri)) {
    http_response_code(403);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'status_code' => 403,
        's'           => 0,
        'o'           => 'Access Forbidden: Direct file access is restricted by security policy.'
    ]);
    exit();
}

// 4. API Request Dispatcher: ?api={Endpoint}
$apiParam = isset($_GET['api']) ? trim(htmlspecialchars(strip_tags($_GET['api']), ENT_QUOTES, 'UTF-8')) : '';

if (!empty($apiParam)) {
    // Sanitize API filename (allow letters, numbers, underscores)
    $cleanApi = preg_replace('/[^a-zA-Z0-9_]/', '', $apiParam);
    $apiFile = __DIR__ . '/BKD/26.10.00/API/' . $cleanApi . '.php';

    if (file_exists($apiFile)) {
        // Load System Bootstrap (Database, Session, Framework constants, Modules)
        require_once __DIR__ . '/BKD/26.10.00/bootstrap.php';

        // Protect account-specific endpoints with the verified PHP session.
        // Public catalogue endpoints remain readable; user-controlled uid/user query
        // parameters never select another account's data.
        $publicAuthEndpoints = ['Nonce','VerifySignature','Register','PasscodeSetup','PasscodeVerify','Currencys','Staking_Plans'];
        $protectedEndpoints = ['User','Transactions','Deposits','Withdraws','Spot_Wallets','Funding_Wallets','Staking_Wallets','Referes','Trades','UserNew','Deposit','Withdraw','Transfer','Profile'];
        if (in_array($cleanApi, $protectedEndpoints, true)) {
            if (empty($_SESSION['passcode_verified']) || empty($_SESSION['user_id'])) {
                http_response_code(401);
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode(['status_code'=>401,'s'=>0,'o'=>'A verified wallet session and passcode are required.']);
                exit();
            }
            $db = function_exists('getDB') ? getDB() : null;
            $sessionUserId = (int)$_SESSION['user_id'];
            if (!$db || !($db instanceof mysqli)) {
                http_response_code(503);
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode(['status_code'=>503,'s'=>0,'o'=>'Database is unavailable.']);
                exit();
            }
            $stmt = mysqli_prepare($db, 'SELECT userid FROM Coinx_users WHERE ID = ? LIMIT 1');
            if (!$stmt) {
                http_response_code(503);
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode(['status_code'=>503,'s'=>0,'o'=>'Account session could not be verified.']);
                exit();
            }
            mysqli_stmt_bind_param($stmt, 'i', $sessionUserId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $sessionUid);
            $sessionUserFound = mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            if (!$sessionUserFound || !is_string($sessionUid) || $sessionUid === '') {
                session_destroy();
                http_response_code(401);
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode(['status_code'=>401,'s'=>0,'o'=>'The authenticated account no longer exists.']);
                exit();
            }
            $_GET['uid'] = $_POST['uid'] = $_REQUEST['uid'] = $sessionUid;
            $_GET['user'] = $_POST['user'] = $_REQUEST['user'] = (string)$sessionUserId;
        }

        // Execute API script
        require $apiFile;
        exit();
    } else {
        http_response_code(404);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'status_code' => 404,
            's'           => 0,
            'c'           => null,
            'o'           => "API endpoint '{$cleanApi}' not found."
        ]);
        exit();
    }
}

// 5. Cron Job Dispatcher: ?cron={CronName}
$cronParam = isset($_GET['cron']) ? trim(htmlspecialchars(strip_tags($_GET['cron']), ENT_QUOTES, 'UTF-8')) : '';

if (!empty($cronParam)) {
    $cleanCron = preg_replace('/[^a-zA-Z0-9_]/', '', $cronParam);
    $cronFile = __DIR__ . '/BKD/26.10.00/Cron/' . $cleanCron . '.php';

    if (file_exists($cronFile)) {
        require_once __DIR__ . '/BKD/26.10.00/bootstrap.php';
        require $cronFile;
        exit();
    } else {
        http_response_code(404);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'status_code' => 404,
            's'           => 0,
            'message'     => "Cron job '{$cleanCron}' not found."
        ]);
        exit();
    }
}

// 5. Default Gateway Info Response (when no ?api= is passed)
header('Content-Type: application/json; charset=UTF-8');
http_response_code(200);

echo json_encode([
    'status_code' => 200,
    's'           => 1,
    'app'         => 'x.money',
    'version'     => '26.10.00',
    'status'      => 'Online',
    'time'        => time(),
    'message'     => 'Welcome to x.money API Gateway. Use ?api={Endpoint} to access endpoints.',
    'example'     => 'https://localhost/x.money/?api=User'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit();
?>
