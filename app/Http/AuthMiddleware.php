<?php
declare(strict_types=1);

final class AuthMiddleware
{
    public static function requireAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (empty($_SESSION['user'])) {
            header("Location: /REAL-ESTATE-PROJECT/public/login.php");
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireAuth();
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "403 Forbidden";
            exit;
        }
    }
}
