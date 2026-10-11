<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$s = 0;
$echo = 'Failed';
$data = null;
$statusCode = 400;

$UID        = isset($_REQUEST['uid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['uid']), ENT_QUOTES, 'UTF-8')) : '';
$Name       = isset($_REQUEST['name']) ? trim(htmlspecialchars(strip_tags($_REQUEST['name']), ENT_QUOTES, 'UTF-8')) : null;
$User       = isset($_REQUEST['user']) ? intval($_REQUEST['user']) : null;
$Privacy    = isset($_REQUEST['privacy']) ? trim(htmlspecialchars(strip_tags($_REQUEST['privacy']), ENT_QUOTES, 'UTF-8')) : null;
$App        = isset($_REQUEST['app']) ? trim(htmlspecialchars(strip_tags($_REQUEST['app']), ENT_QUOTES, 'UTF-8')) : null;
$Ttype      = isset($_REQUEST['ttype']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ttype']), ENT_QUOTES, 'UTF-8')) : null;
$Amount     = isset($_REQUEST['amount']) ? trim(htmlspecialchars(strip_tags($_REQUEST['amount']), ENT_QUOTES, 'UTF-8')) : null;
$CCC        = isset($_REQUEST['ccc']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ccc']), ENT_QUOTES, 'UTF-8')) : null;
$Status     = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : null;
$Balance    = isset($_REQUEST['balance']) ? trim(htmlspecialchars(strip_tags($_REQUEST['balance']), ENT_QUOTES, 'UTF-8')) : null;
$Processing = isset($_REQUEST['processing']) ? intval($_REQUEST['processing']) : null;
$OrderId    = isset($_REQUEST['orderid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['orderid']), ENT_QUOTES, 'UTF-8')) : null;

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        if (!empty(i['id']) || 1) {
            if (!empty($UID)) {
                if (Cron($UID)) {
                    $Array = [
                        'uid'        => $UID,
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

                    $Filtered = array_filter($Array, function($v) { return $v !== null && $v !== ''; });

                    if (count($Filtered) > 1) {
                        $CronUpdate = CronUpdate($Filtered);
                        if ($CronUpdate) {
                            $s = 1;
                            $echo = 'Update Successfully';
                            $data = $CronUpdate;
                            $statusCode = 200; // OK
                        } else {
                            $s = 0;
                            $echo = 'Update Attempt Failed.';
                            $statusCode = 500; // Server Error
                        }
                    } else {
                        $s = 0;
                        $echo = 'At least one field is required to update.';
                        $statusCode = 400; // Bad Request
                    }
                } else {
                    $s = 0;
                    $echo = 'UID not match.';
                    $statusCode = 404; // Not Found
                }
            } else {
                $s = 0;
                $echo = 'Uid Required.';
                $statusCode = 400; // Bad Request
            }
        } else {
            $s = 0;
            $echo = 'Login First.';
            $statusCode = 401; // Unauthorized
        }
    } else {
        $s = 0;
        $echo = 'Update New in Fiat available very soon.';
        $statusCode = 503; // Service Unavailable
    }
} else {
    $s = 0;
    $echo = 'Update New Allow After Grand Launch.';
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
