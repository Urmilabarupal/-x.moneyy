<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$s = 0;
$echo = 'Failed';
$data = null;
$statusCode = 400;

// Secure sanitized input extraction
$Name        = isset($_REQUEST['name']) ? trim(htmlspecialchars(strip_tags($_REQUEST['name']), ENT_QUOTES, 'UTF-8')) : '';
$User        = isset($_REQUEST['user']) ? intval($_REQUEST['user']) : (isset(i['id']) ? intval(i['id']) : 0);
$Privacy     = isset($_REQUEST['privacy']) ? trim(htmlspecialchars(strip_tags($_REQUEST['privacy']), ENT_QUOTES, 'UTF-8')) : '';
$App         = isset($_REQUEST['app']) ? trim(htmlspecialchars(strip_tags($_REQUEST['app']), ENT_QUOTES, 'UTF-8')) : '';
$Ttype       = isset($_REQUEST['ttype']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ttype']), ENT_QUOTES, 'UTF-8')) : '';
$Amount      = isset($_REQUEST['amount']) ? trim(htmlspecialchars(strip_tags($_REQUEST['amount']), ENT_QUOTES, 'UTF-8')) : '0';
$CCC         = isset($_REQUEST['ccc']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ccc']), ENT_QUOTES, 'UTF-8')) : '';
$Status      = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : 1;
$Balance     = isset($_REQUEST['balance']) ? trim(htmlspecialchars(strip_tags($_REQUEST['balance']), ENT_QUOTES, 'UTF-8')) : '0';
$Processing  = isset($_REQUEST['processing']) ? intval($_REQUEST['processing']) : 0;
$OrderId     = isset($_REQUEST['orderid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['orderid']), ENT_QUOTES, 'UTF-8')) : '';

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        if (!empty(i['id']) || 1) {
            $Array = [
                'name'       => $Name,
                'user'       => $User,
                'privacy'    => $Privacy,
                'app'        => $App,
                'ttype'      => $Ttype,
                'amount'     => $Amount,
                'ccc'        => $CCC,
                'status'     => $Status,
                'balance'    => $Balance,
                'processing' => $Processing,
                'orderid'    => $OrderId
            ];

            $Filtered = array_filter($Array, function($v) { return $v !== '' && $v !== null; });

            if (!empty($Filtered)) {
                $Convert_IncomeNew = Convert_IncomeNew($Filtered);
                if ($Convert_IncomeNew) {
                    $s = 1;
                    $echo = 'Success.';
                    $data = $Convert_IncomeNew;
                    $statusCode = 201; // Created
                } else {
                    $s = 0;
                    $echo = 'Creation Attempt Failed.';
                    $statusCode = 500; // Server Error
                }
            } else {
                $s = 0;
                $echo = 'All parameter required.';
                $statusCode = 400; // Bad Request
            }
        } else {
            $s = 0;
            $echo = 'Login First Please.';
            $statusCode = 401; // Unauthorized
        }
    } else {
        $s = 0;
        $echo = 'Convert Income New in Fiat available very soon.';
        $statusCode = 503; // Service Unavailable
    }
} else {
    $s = 0;
    $echo = 'Convert Income New Allow After Grand Launch.';
    $statusCode = 403; // Forbidden
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
