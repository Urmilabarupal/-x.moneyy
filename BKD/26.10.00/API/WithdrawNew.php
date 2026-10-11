<?php
require_once __DIR__ . '/financial_security.php';
secure_financial_request(['POST']);

$s = 0;
$echo = 'Failed';
$data = null;
$statusCode = 400;

// 1. Strict Validation of Withdrawal Inputs
$AmountRaw = isset($_POST['amount']) ? trim($_POST['amount']) : (isset($_REQUEST['amount']) ? trim($_REQUEST['amount']) : '0');
$Amount    = floatval($AmountRaw);

if ($Amount <= 0) {
    http_response_code(400);
    echo json_encode([
        'status_code' => 400,
        's'           => 0,
        't'           => function_exists('GMT') ? GMT() : time(),
        'c'           => null,
        'o'           => 'Invalid withdrawal amount. Amount must be positive and greater than zero.'
    ]);
    exit();
}

$Name        = isset($_REQUEST['name']) ? trim(htmlspecialchars(strip_tags($_REQUEST['name']), ENT_QUOTES, 'UTF-8')) : 'Withdraw';
$User        = isset($_REQUEST['user']) ? intval($_REQUEST['user']) : (isset(i['id']) ? intval(i['id']) : 0);
$Privacy     = isset($_REQUEST['privacy']) ? trim(htmlspecialchars(strip_tags($_REQUEST['privacy']), ENT_QUOTES, 'UTF-8')) : 'Public';
$App         = isset($_REQUEST['app']) ? trim(htmlspecialchars(strip_tags($_REQUEST['app']), ENT_QUOTES, 'UTF-8')) : 'Web';
$Ttype       = isset($_REQUEST['ttype']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ttype']), ENT_QUOTES, 'UTF-8')) : 'Withdraw';
$CCC         = isset($_REQUEST['ccc']) ? strtoupper(trim(htmlspecialchars(strip_tags($_REQUEST['ccc']), ENT_QUOTES, 'UTF-8'))) : '';
$Status      = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : 0; // Default pending review
$Balance     = isset($_REQUEST['balance']) ? trim(htmlspecialchars(strip_tags($_REQUEST['balance']), ENT_QUOTES, 'UTF-8')) : '0';
$Processing  = isset($_REQUEST['processing']) ? intval($_REQUEST['processing']) : 0;
$OrderId     = isset($_REQUEST['orderid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['orderid']), ENT_QUOTES, 'UTF-8')) : ('WTH_' . time() . '_' . rand(1000, 9999));

if (empty($CCC)) {
    http_response_code(400);
    echo json_encode([
        'status_code' => 400,
        's'           => 0,
        't'           => function_exists('GMT') ? GMT() : time(),
        'c'           => null,
        'o'           => 'Currency code (CCC) is required.'
    ]);
    exit();
}

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        $ActiveUser = $User ? $User : (isset(i['id']) ? intval(i['id']) : 0);
        if (!empty($ActiveUser)) {
            // Check wallet balance if Wallets helper exists
            if (function_exists('Wallets')) {
                $userWallets = Wallets($ActiveUser);
                if (isset($userWallets[$CCC]) && floatval($userWallets[$CCC]) < $Amount) {
                    http_response_code(400);
                    echo json_encode([
                        'status_code' => 400,
                        's'           => 0,
                        't'           => function_exists('GMT') ? GMT() : time(),
                        'c'           => null,
                        'o'           => 'Insufficient balance for withdrawal.'
                    ]);
                    exit();
                }
            }

            $Array = [
                'name'       => $Name,
                'user'       => $ActiveUser,
                'privacy'    => $Privacy,
                'app'        => $App,
                'ttype'      => $Ttype,
                'amount'     => number_format($Amount, 8, '.', ''),
                'ccc'        => $CCC,
                'status'     => $Status,
                'balance'    => $Balance,
                'processing' => $Processing,
                'orderid'    => $OrderId
            ];

            $WithdrawNew = WithdrawNew($Array);
            if ($WithdrawNew) {
                $s = 1;
                $echo = 'Withdrawal request submitted successfully.';
                $data = $WithdrawNew;
                $statusCode = 201;
            } else {
                $s = 0;
                $echo = 'Withdrawal creation failed in database.';
                $statusCode = 500;
            }
        } else {
            $s = 0;
            $echo = 'Authentication Required. Please login.';
            $statusCode = 401;
        }
    } else {
        $s = 0;
        $echo = 'Withdrawal New in Fiat available very soon.';
        $statusCode = 503;
    }
} else {
    $s = 0;
    $echo = 'Withdrawal Allow After Grand Launch.';
    $statusCode = 403;
}

http_response_code($statusCode);

$JSON = array(
    'status_code' => $statusCode,
    's'           => $s,
    't'           => function_exists('GMT') ? GMT() : time(),
    'c'           => $data,
    'o'           => $echo
);

echo json_encode($JSON, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
