<?php

namespace App\Security;

class CsrfTokenManager
{
    private const SESSION_KEY = '_csrf_token';

    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_KEY] = $token;

        return $token;
    }

    public static function getToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION[self::SESSION_KEY])) {
            return self::generateToken();
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function validateToken(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION[self::SESSION_KEY])) {
            return false;
        }

        $isValid = hash_equals($_SESSION[self::SESSION_KEY], (string) $token);

        if ($isValid) {
            unset($_SESSION[self::SESSION_KEY]);
        }

        return $isValid;
    }
}
