<?php
declare(strict_types=1);

require_once __DIR__ . '/../Repositories/UserRepository.php';

final class AuthService
{
    public function register(string $name, string $email, string $password): array
    {
        $repo = new UserRepository();

        if ($repo->findByEmail($email)) {
            return ['ok' => false, 'error' => 'Email already exists.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $repo->create($name, $email, $hash, 'user');

        return ['ok' => true, 'user_id' => $userId];
    }

    public function login(string $email, string $password): array
    {
        $repo = new UserRepository();
        $u = $repo->findByEmail($email);

        if (!$u)
            return ['ok' => false, 'error' => 'Invalid credentials.'];
        if ((int) $u['is_active'] !== 1)
            return ['ok' => false, 'error' => 'User is inactive.'];
        if (!password_verify($password, (string) $u['password_hash'])) {
            return ['ok' => false, 'error' => 'Invalid credentials.'];
        }

        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['user'] = [
            'id' => (int) $u['id'],
            'name' => (string) $u['name'],
            'role' => (string) $u['role'],
            'email' => (string) $u['email'],
        ];

        return ['ok' => true];
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION = [];
        session_destroy();
    }
}
