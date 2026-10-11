<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$s = 0;
$echo = 'Failed';
$data = null;
$statusCode = 400;

$Uid = isset($_REQUEST['uid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['uid']), ENT_QUOTES, 'UTF-8')) : '';

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        if (!empty($Uid)) {
            $Withdraw_Bonus = Withdraw_Bonus($Uid);
            if ($Withdraw_Bonus) {
                $s = 1;
                $echo = 'Success';
                $data = $Withdraw_Bonus;
                $statusCode = 200;
            } else {
                $s = 0;
                $echo = 'Withdraw Bonus Not Found.';
                $statusCode = 404;
            }
        } else {
            $s = 0;
            $echo = 'Uid Required.';
            $statusCode = 400;
        }
    } else {
        $s = 0;
        $echo = 'Withdraw Bonus in Fiat available very soon.';
        $statusCode = 503;
    }
} else {
    $s = 0;
    $echo = 'Withdraw Bonus Allow After Grand Launch.';
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
