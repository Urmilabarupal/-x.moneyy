<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$s = 0;
$echo = 'Empty';
$o = [];
$statusCode = 400;

$Id         = isset($_REQUEST['id']) ? trim(htmlspecialchars(strip_tags($_REQUEST['id']), ENT_QUOTES, 'UTF-8')) : '';
$UID        = isset($_REQUEST['uid']) ? trim(htmlspecialchars(strip_tags($_REQUEST['uid']), ENT_QUOTES, 'UTF-8')) : '';
$Name       = isset($_REQUEST['name']) ? trim(htmlspecialchars(strip_tags($_REQUEST['name']), ENT_QUOTES, 'UTF-8')) : '';
$User       = isset($_REQUEST['user']) ? trim(htmlspecialchars(strip_tags($_REQUEST['user']), ENT_QUOTES, 'UTF-8')) : (isset(i['id']) ? i['id'] : '');
$Privacy    = isset($_REQUEST['privacy']) ? trim(htmlspecialchars(strip_tags($_REQUEST['privacy']), ENT_QUOTES, 'UTF-8')) : '';
$App        = isset($_REQUEST['app']) ? trim(htmlspecialchars(strip_tags($_REQUEST['app']), ENT_QUOTES, 'UTF-8')) : '';
$Ttype      = isset($_REQUEST['ttype']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ttype']), ENT_QUOTES, 'UTF-8')) : '';
$Amount     = isset($_REQUEST['amount']) ? trim(htmlspecialchars(strip_tags($_REQUEST['amount']), ENT_QUOTES, 'UTF-8')) : '';
$CCC        = isset($_REQUEST['ccc']) ? trim(htmlspecialchars(strip_tags($_REQUEST['ccc']), ENT_QUOTES, 'UTF-8')) : '';
$Status     = isset($_REQUEST['status']) ? trim(htmlspecialchars(strip_tags($_REQUEST['status']), ENT_QUOTES, 'UTF-8')) : '';
$Balance    = isset($_REQUEST['balance']) ? trim(htmlspecialchars(strip_tags($_REQUEST['balance']), ENT_QUOTES, 'UTF-8')) : '';
$Processing = isset($_REQUEST['processing']) ? trim(htmlspecialchars(strip_tags($_REQUEST['processing']), ENT_QUOTES, 'UTF-8')) : '';
$Platform   = isset($_REQUEST['platform']) ? strtolower(trim(htmlspecialchars(strip_tags($_REQUEST['platform']), ENT_QUOTES, 'UTF-8'))) : '';
$Limit      = isset($_REQUEST['LIMIT']) ? intval($_REQUEST['LIMIT']) : (isset($_REQUEST['limit']) ? intval($_REQUEST['limit']) : 50);
$Offset     = isset($_REQUEST['OFFSET']) ? intval($_REQUEST['OFFSET']) : (isset($_REQUEST['offset']) ? intval($_REQUEST['offset']) : 0);

if (defined('Setting') && isset(Setting['launched']) && Setting['launched']) {
    if (1) {
        $Array = [
            'id'         => $Id,
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
            'LIMIT'      => $Limit,
            'OFFSET'     => $Offset
        ];

        $FilterArray = array_filter($Array, function($v) { return $v !== '' && $v !== null; });

        $res = Settings($FilterArray);

        if (!empty($res)) {
            $s = 1;
            $echo = 'Success.';
            $statusCode = 200; // OK
            $formatted = [];

            foreach ($res as $row) {
                if (isset($row['ccc']) && strtolower($row['ccc']) === 'ccc') {
                    $row['ccc'] = 'Coin';
                } elseif (isset($row['ccc'])) {
                    $row['ccc'] = strtoupper($row['ccc']);
                }

                if (isset($row['amount']) && function_exists('d2p')) {
                    $row['fnamount'] = function_exists('FNs') ? FNs(d2p($row['amount']), 4) : number_format(d2p($row['amount']), 4);
                    $row['amount'] = number_format(d2p($row['amount']), 2);
                }

                if (isset($row['price'])) {
                    $row['price'] = number_format(floatval($row['price']), 4);
                }

                $formatted[] = $row;
            }

            $o = $formatted;
        } else {
            $s = 0;
            $echo = 'Setting Data Not Found.';
            $statusCode = 200; // OK with empty list
            $o = [];
        }
    } else {
        $s = 0;
        $echo = 'Search New in Fiat available very soon.';
        $statusCode = 503; // Service Unavailable
    }
} else {
    $s = 0;
    $echo = 'Search New Allow After Grand Launch.';
    $statusCode = 403; // Forbidden
}

http_response_code($statusCode);

if ($Platform === 'app') {
    $JSON = $o;
} else {
    $JSON = array(
        'status_code' => $statusCode,
        's'           => $s,
        't'           => function_exists('GMT') ? GMT() : time(),
        'c'           => $echo,
        'o'           => $o
    );
}

echo json_encode($JSON, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
