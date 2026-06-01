<?php

class JWT {
    private static $secret;

    public static function setSecret($secret) {
        self::$secret = $secret;
    }

    public static function encode($data) {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($data);
        $signature = '';

        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);

        $signature = hash_hmac(
            'sha256',
            $base64UrlHeader . '.' . $base64UrlPayload,
            self::$secret,
            true
        );
        $base64UrlSignature = self::base64UrlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    public static function decode($token) {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;

        $isValid = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            self::$secret,
            true
        );

        if (!hash_equals($signature, self::base64UrlEncode($isValid))) {
            return false;
        }

        $decoded = json_decode(self::base64UrlDecode($payload), true);
        return $decoded;
    }

    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 4 - strlen($data) % 4));
    }
}

function getAuthToken() {
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        $matches = [];
        if (preg_match('/Bearer\s+(.+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function verifyToken($token) {
    if (!$token) {
        return false;
    }
    return JWT::decode($token);
}
