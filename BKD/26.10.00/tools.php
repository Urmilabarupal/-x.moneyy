<?php
/**
 * Global Utilities & Helper Functions Library
 * Location: C:\xampp\htdocs\x.money\BKD\26.10.00\tools.php
 */

// ==============================================================================
// 1. Time, Date & GMT Helpers
// ==============================================================================

if (!function_exists('GMT')) {
    function GMT() {
        return time();
    }
}

if (!function_exists('GMTDate')) {
    function GMTDate($format = 'Y-m-d H:i:s') {
        return gmdate($format);
    }
}

if (!function_exists('IST')) {
    function IST($format = 'Y-m-d H:i:s') {
        return date($format, time() + (330 * 60)); // +5:30 IST
    }
}

if (!function_exists('TimeNow')) {
    function TimeNow() {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('Today')) {
    function Today() {
        return gmdate('D');
    }
}

if (!function_exists('Holiday')) {
    function Holiday() {
        $today = Today();
        return ($today === 'Sun' || $today === 'Sat') ? 1 : 0;
    }
}

if (!function_exists('diff_in_seconds')) {
    function diff_in_seconds($start, $end = null) {
        $endTime = $end ? strtotime($end) : time();
        $startTime = strtotime($start);
        return abs($endTime - $startTime);
    }
}

if (!function_exists('TimePlusDays')) {
    function TimePlusDays($days, $time = null) {
        $base = $time ? strtotime($time) : time();
        return date('Y-m-d H:i:s', strtotime("+{$days} days", $base));
    }
}

if (!function_exists('TimeMinusDays')) {
    function TimeMinusDays($days, $time = null) {
        $base = $time ? strtotime($time) : time();
        return date('Y-m-d H:i:s', strtotime("-{$days} days", $base));
    }
}

if (!function_exists('TimePlusMinutes')) {
    function TimePlusMinutes($minutes, $time = null) {
        $base = $time ? strtotime($time) : time();
        return date('Y-m-d H:i:s', strtotime("+{$minutes} minutes", $base));
    }
}

// ==============================================================================
// 2. Financial & Crypto Units Conversion Helpers (d2p, p2d)
// ==============================================================================

/**
 * Decimal to Points / Precision conversion
 * Multiplies by 1,000,000,000 (9 decimals) or custom factor
 */
if (!function_exists('p2d')) {
    function p2d($amount, $precision = 1000000000) {
        if ($amount === null || $amount === '') return 0;
        return floatval($amount) * $precision;
    }
}

/**
 * Points / Raw Satoshi to Decimal display conversion
 * Divides by 1,000,000,000 (9 decimals) or custom factor
 */
if (!function_exists('d2p')) {
    function d2p($amount, $precision = 1000000000) {
        if ($amount === null || $amount === '' || $precision == 0) return 0;
        return floatval($amount) / $precision;
    }
}

if (!function_exists('FNs')) {
    function FNs($number, $decimals = 4) {
        return number_format(floatval($number), $decimals, '.', '');
    }
}

if (!function_exists('FormatAmount')) {
    function FormatAmount($number, $decimals = 2) {
        return number_format(floatval($number), $decimals, '.', ',');
    }
}

if (!function_exists('Percent')) {
    function Percent($amount, $percent) {
        if ($amount && $percent) {
            return ($amount * $percent) / 100;
        }
        return 0;
    }
}

// ==============================================================================
// 3. String & Number Utility Helpers
// ==============================================================================

if (!function_exists('randomString')) {
    function randomString($length = 16) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[random_int(0, $max)];
        }
        return $str;
    }
}

if (!function_exists('randomOTP')) {
    function randomOTP($length = 6) {
        $digits = '';
        for ($i = 0; $i < $length; $i++) {
            $digits .= random_int(0, 9);
        }
        return $digits;
    }
}

if (!function_exists('CleanNumber')) {
    function CleanNumber($num) {
        return str_replace([',', ' '], '', $num);
    }
}

if (!function_exists('NS')) {
    function NS($number, $precision = 2) {
        $num = floatval($number);
        if (abs($num) >= 1000000000000) {
            return number_format($num / 1000000000000, $precision) . 'T';
        } elseif (abs($num) >= 1000000000) {
            return number_format($num / 1000000000, $precision) . 'B';
        } elseif (abs($num) >= 1000000) {
            return number_format($num / 1000000, $precision) . 'M';
        } elseif (abs($num) >= 1000) {
            return number_format($num / 1000, $precision) . 'K';
        }
        return number_format($num, $precision);
    }
}

if (!function_exists('CurrencySymbol')) {
    function CurrencySymbol($ccc) {
        $c = strtoupper($ccc);
        $map = [
            'USDT' => '$',
            'USD'  => '$',
            'INR'  => '₹',
            'EUR'  => '€',
            'GBP'  => '£',
            'BTC'  => '₿',
            'ETH'  => 'Ξ'
        ];
        return isset($map[$c]) ? $map[$c] : $c;
    }
}

// ==============================================================================
// 4. Request & Input Helpers
// ==============================================================================

if (!function_exists('REQUEST')) {
    function REQUEST($key, $default = null) {
        if (!isset($_REQUEST[$key])) return $default;
        $val = $_REQUEST[$key];
        if (is_string($val)) {
            return trim(htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8'));
        }
        return $val;
    }
}

if (!function_exists('POST')) {
    function POST($key, $default = null) {
        if (!isset($_POST[$key])) return $default;
        $val = $_POST[$key];
        if (is_string($val)) {
            return trim(htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8'));
        }
        return $val;
    }
}

if (!function_exists('GET')) {
    function GET($key, $default = null) {
        if (!isset($_GET[$key])) return $default;
        $val = $_GET[$key];
        if (is_string($val)) {
            return trim(htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8'));
        }
        return $val;
    }
}

if (!function_exists('JsonOut')) {
    function JsonOut($status, $code, $message, $data = null) {
        http_response_code($code);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'status_code' => $code,
            's'           => $status,
            't'           => time(),
            'c'           => $data,
            'o'           => $message
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit();
    }
}
?>
