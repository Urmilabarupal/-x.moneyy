<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$s = 0;
$echo = 'Failed';
$data = null;
$statusCode = 400;

$UID    = isset($_REQUEST['uid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['uid']), ENT_QUOTES, 'UTF-8')) : '';
$Status = isset($_REQUEST['status']) ? strtolower(trim(htmlspecialchars(strip_tags($_REQUEST['status']), ENT_QUOTES, 'UTF-8'))) : '';

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        if (!empty(i['id']) || 1) {
            if (!empty($UID)) {
                if (Cron($UID)) {
                    if ($Status === 'enable' || $Status === 'disable' || $Status === '1' || $Status === '0') {
                        $statusVal = ($Status === 'enable' || $Status === '1') ? 1 : 0;
                        $CronStatus = CronStatus($UID, $statusVal);

                        if ($CronStatus) {
                            $s = 1;
                            $echo = 'Success';
                            $data = $CronStatus;
                            $statusCode = 200; // OK
                        } else {
                            $s = 0;
                            $echo = 'Status Update Failed.';
                            $statusCode = 500; // Server Error
                        }
                    } else {
                        $s = 0;
                        $echo = 'Status must be Enable or Disable.';
                        $statusCode = 400; // Bad Request
                    }
                } else {
                    $s = 0;
                    $echo = 'UID not match.';
                    $statusCode = 404; // Not Found
                }
            } else {
                $s = 0;
                $echo = 'UID Required.';
                $statusCode = 400; // Bad Request
            }
        } else {
            $s = 0;
            $echo = 'Login First.';
            $statusCode = 401; // Unauthorized
        }
    } else {
        $s = 0;
        $echo = 'Cron Status in Fiat available very soon.';
        $statusCode = 503; // Service Unavailable
    }
} else {
    $s = 0;
    $echo = 'Cron Status Allow After Grand Launch.';
    $statusCode = 403; // Forbidden
}

http_response_code($statusCode);

$JSON = array(
    'status_code' => $statusCode,
    's'           => $s,
    't'           => function_exists('GMT') ? GMT() : time(),
    'o'           => $data,
    'c'           => $echo
);

echo json_encode($JSON, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
