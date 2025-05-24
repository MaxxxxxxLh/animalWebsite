<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SecurityHelper
{
    private static ?string $jwtSecret = null;

    private static function getSecret(): string
    {
        if (self::$jwtSecret === null) {
            self::$jwtSecret = trim(file_get_contents(__DIR__ . '/jwt.key'));
        }
        return self::$jwtSecret;
    }

    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function generateAccessToken(int $userId, int $duration = 900): string 
    {
        $payload = [
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + $duration
        ];

        return JWT::encode($payload, self::getSecret(), 'HS256');
    }

    public static function verifyAccessToken(string $token): ?int
    {
        try {
            $decoded = JWT::decode($token, new Key(self::getSecret(), 'HS256'));
            return $decoded->sub ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function generateRefreshToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    public static function storeRefreshToken(int $userId, string $token): void
    {
        $_SESSION['refresh_tokens'][$userId] = [
            'token' => $token,
            'expires_at' => time() + 60 * 60 * 24 * 7 
        ];
    }

    public static function verifyRefreshToken(int $userId, string $token): bool
    {
        if (!isset($_SESSION['refresh_tokens'][$userId])) {
            return false;
        }

        $data = $_SESSION['refresh_tokens'][$userId];

        return hash_equals($data['token'], $token) && $data['expires_at'] > time();
    }
}
