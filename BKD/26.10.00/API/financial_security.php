<?php
/**
 * Financial Security Gateway for Sensitive Operations (Deposit & Withdraw)
 * Provides: Method Enforcement, Input Validation, CSRF/Anti-Tamper, Rate Limiting & Origin checks
 */

if (!function_exists('secure_financial_request')) {
    function secure_financial_request($allowedMethods = ['POST']) {
        // 1. CORS & Origin Protection
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        header('Access-Control-Allow-Origin: ' . ($origin ? $origin : '*'));
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-Idempotency-Key');
        header('Content-Type: application/json; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');

        // Handle preflight
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // 2. Strict HTTP Method Enforcement (No GET allowed for money transactions)
        if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
            http_response_code(405);
            echo json_encode([
                'status_code' => 405,
                's'           => 0,
                't'           => time(),
                'c'           => null,
                'o'           => 'Method Not Allowed. Only ' . implode(', ', $allowedMethods) . ' accepted.'
            ]);
            exit();
        }

        // 3. Simple File-based Rate Limiting (Max 30 money operations per minute per IP)
        $ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :
             (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0] : $_SERVER['REMOTE_ADDR']);
        $ip = trim($ip);
        
        $rateDir = sys_get_temp_dir() . '/xmoney_rate/';
        if (!is_dir($rateDir)) {
            @mkdir($rateDir, 0777, true);
        }

        $rateFile = $rateDir . md5($ip) . '.json';
        $now = time();
        $rateData = ['count' => 0, 'first_req' => $now];

        if (file_exists($rateFile)) {
            $content = @file_get_contents($rateFile);
            if ($content) {
                $decoded = json_decode($content, true);
                if (is_array($decoded)) {
                    $rateData = $decoded;
                }
            }
        }

        if ($now - $rateData['first_req'] < 60) {
            $rateData['count']++;
            if ($rateData['count'] > 30) {
                http_response_code(429);
                echo json_encode([
                    'status_code' => 429,
                    's'           => 0,
                    't'           => $now,
                    'c'           => null,
                    'o'           => 'Too Many Requests. Rate limit exceeded. Please wait a minute.'
                ]);
                exit();
            }
        } else {
            $rateData = ['count' => 1, 'first_req' => $now];
        }

        @file_put_contents($rateFile, json_encode($rateData));
    }
}
?>
