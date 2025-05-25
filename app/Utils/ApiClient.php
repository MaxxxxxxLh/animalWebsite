<?php

namespace App\Utils;

class ApiClient
{
    private static function getCsrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }

    private static function getAccessToken(): ?string
    {
        return $_SESSION['user']['access_token'] ?? null;
    }

    private static function getRefreshToken(): ?string
    {
        return $_SESSION['user']['refresh_token'] ?? null;
    }

    private static function saveTokens(string $accessToken, string $refreshToken): void
    {
        if (isset($_SESSION['user'])) {
            $_SESSION['user']['access_token'] = $accessToken;
            $_SESSION['user']['refresh_token'] = $refreshToken;
        }
    }

  
    private static function refreshToken(): bool
    {
        $refreshToken = self::getRefreshToken();
        if (!$refreshToken) {
            return false;
        }

        $url = "http://localhost/api/auth/refresh-token";
        $headers = [
            "Content-Type: application/json",
            "X-CSRF-Token: " . self::getCsrfToken(),
        ];

        $data = ['refresh_token' => $refreshToken];

        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        $result = json_decode($response, true);
        if (isset($result['access_token'], $result['refresh_token'])) {
            self::saveTokens($result['access_token'], $result['refresh_token']);
            return true;
        }

        return false;
    }

    public static function get(string $url): array
    {
        $headers = [
            "Content-Type: application/json",
            "X-CSRF-Token: " . self::getCsrfToken(),
        ];

        $accessToken = self::getAccessToken();
        if ($accessToken) {
            $headers[] = "Authorization: Bearer " . $accessToken;
        }

        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'GET',
            ],
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API GET request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $data = json_decode($response, true);

        if (self::isUnauthorized($http_response_header)) {
            if (self::refreshToken()) {
                return self::get($url);
            } else {
                self::logoutSession();
                return ['error' => 'Session expirée, veuillez vous reconnecter.'];
            }
        }

        return is_array($data) ? $data : ['error' => 'Invalid JSON'];
    }


    public static function post(string $url, array $data): array
    {
        $headers = [
            "Content-Type: application/json",
            "X-CSRF-Token: " . self::getCsrfToken(),
        ];

        $accessToken = self::getAccessToken();
        if ($accessToken) {
            $headers[] = "Authorization: Bearer " . $accessToken;
        }

        $options = [
            'http' => [
                'header'  => implode("\r\n", $headers),
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API POST request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $result = json_decode($response, true);

        if (self::isUnauthorized($http_response_header)) {
            if (self::refreshToken()) {
                return self::post($url, $data);
            } else {
                self::logoutSession();
                return ['error' => 'Session expirée, veuillez vous reconnecter.'];
            }
        }

        return is_array($result) ? $result : ['error' => 'Invalid JSON: ' . $response];
    }

    public static function delete(string $url): array
    {
        $headers = [
            "Content-Type: application/json",
            "X-CSRF-Token: " . self::getCsrfToken(),
        ];

        $accessToken = self::getAccessToken();
        if ($accessToken) {
            $headers[] = "Authorization: Bearer " . $accessToken;
        }

        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'DELETE',
            ],
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API DELETE request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $result = json_decode($response, true);

        if (self::isUnauthorized($http_response_header)) {
            if (self::refreshToken()) {
                return self::delete($url);
            } else {
                self::logoutSession();
                return ['error' => 'Session expirée, veuillez vous reconnecter.'];
            }
        }

        return is_array($result) ? $result : ['error' => 'Invalid JSON: ' . $response];
    }


    private static function isUnauthorized(array $headers): bool
    {
        foreach ($headers as $header) {
            if (stripos($header, 'HTTP/') === 0 && preg_match('#HTTP/\d\.\d\s+401#', $header)) {
                return true;
            }
        }
        return false;
    }

    private static function logoutSession(): void
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}
