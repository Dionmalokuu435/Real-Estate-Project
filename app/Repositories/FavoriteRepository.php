<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

final class FavoriteRepository
{
    public function isFavorite(int $userId, int $propertyId): bool
    {
        $stmt = Database::pdo()->prepare(
            "SELECT 1 FROM favorites WHERE user_id = ? AND property_id = ? LIMIT 1"
        );
        $stmt->execute([$userId, $propertyId]);
        return (bool) $stmt->fetchColumn();
    }

    public function add(int $userId, int $propertyId): void
    {
        $stmt = Database::pdo()->prepare(
            "INSERT IGNORE INTO favorites (user_id, property_id) VALUES (?, ?)"
        );
        $stmt->execute([$userId, $propertyId]);
    }

    public function remove(int $userId, int $propertyId): void
    {
        $stmt = Database::pdo()->prepare(
            "DELETE FROM favorites WHERE user_id = ? AND property_id = ?"
        );
        $stmt->execute([$userId, $propertyId]);
    }

    public function toggle(int $userId, int $propertyId): bool
    {
        if ($this->isFavorite($userId, $propertyId)) {
            $this->remove($userId, $propertyId);
            return false;
        }

        $this->add($userId, $propertyId);
        return true;
    }
    public function getFavoritePropertyIds(int $userId, array $propertyIds): array
    {
        if (!$propertyIds)
            return [];

        $placeholders = implode(',', array_fill(0, count($propertyIds), '?'));
        $params = array_merge([$userId], $propertyIds);

        $stmt = Database::pdo()->prepare("
        SELECT property_id
        FROM favorites
        WHERE user_id = ?
          AND property_id IN ($placeholders)
    ");
        $stmt->execute($params);

        $rows = $stmt->fetchAll();
        $set = [];
        foreach ($rows as $r) {
            $set[(int) $r['property_id']] = true;
        }
        return $set;
    }

}
