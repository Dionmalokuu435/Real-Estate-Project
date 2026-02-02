<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

final class UserRepository
{
    public function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        return $u ?: null;
    }

    public function create(string $name, string $email, string $passwordHash, string $role = 'user'): int
    {
        $stmt = Database::pdo()->prepare("
            INSERT INTO users (name, email, password_hash, role, is_active)
            VALUES (?, ?, ?, ?, 1)
        ");
        $stmt->execute([$name, $email, $passwordHash, $role]);
        return (int) Database::pdo()->lastInsertId();
    }
}
