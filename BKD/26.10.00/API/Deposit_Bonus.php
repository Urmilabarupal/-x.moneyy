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
            $Deposit_Bonus = Deposit_Bonus($Uid);
            if ($Deposit_Bonus) {
                $s = 1;
                $echo = 'Success';
                $data = $Deposit_Bonus;
                $statusCode = 200;
            } else {
                $s = 0;
                $echo = 'Deposit Bonus Not Found.';
                $statusCode = 404;
            }
        } else {
            $s = 0;
            $echo = 'Uid Required.';
            $statusCode = 400;
        }
    } else {
        $s = 0;
        $echo = 'Deposit Bonus in Fiat available very soon.';
        $statusCode = 503;
    }
} else {
    $s = 0;
    $echo = 'Deposit Bonus Allow After Grand Launch.';
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
