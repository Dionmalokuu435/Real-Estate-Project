<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

final class AdminRepository
{
    public function getStats(): array
    {
        $pdo = Database::pdo();
        return [
            'total_properties' => (int) $pdo->query("SELECT COUNT(*) FROM properties")->fetchColumn(),
            'active_properties' => (int) $pdo->query("SELECT COUNT(*) FROM properties WHERE status = 'active'")->fetchColumn(),
            'users' => (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'favorites' => (int) $pdo->query("SELECT COUNT(*) FROM favorites")->fetchColumn(),
        ];
    }

    public function getRecentProperties(int $limit = 5): array
    {
        $limit = max(1, min($limit, 50));
        $sql = "
            SELECT p.*,
              (SELECT m.file_path
               FROM media m
               WHERE m.property_id = p.id AND m.is_primary = 1
               ORDER BY m.id DESC
               LIMIT 1) AS primary_image
            FROM properties p
            ORDER BY p.id DESC
            LIMIT {$limit}
        ";
        return Database::pdo()->query($sql)->fetchAll();
    }

    public function listProperties(): array
    {
        $sql = "
            SELECT p.*,
              (SELECT m.file_path
               FROM media m
               WHERE m.property_id = p.id AND m.is_primary = 1
               ORDER BY m.id DESC
               LIMIT 1) AS primary_image
            FROM properties p
            ORDER BY p.id DESC
        ";
        return Database::pdo()->query($sql)->fetchAll();
    }

    public function getProperty(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM properties WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getPropertyFeatures(int $propertyId): array
    {
        $stmt = Database::pdo()->prepare("
            SELECT id, icon, label, value, sort_order
            FROM property_features
            WHERE property_id = ?
            ORDER BY sort_order ASC, id ASC
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public function getPropertyMedia(int $propertyId): array
    {
        $stmt = Database::pdo()->prepare("
            SELECT id, file_type, file_path, original_name, mime_type, size_bytes, is_primary
            FROM media
            WHERE property_id = ?
            ORDER BY is_primary DESC, id ASC
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public function createProperty(array $data, int $userId): int
    {
        $stmt = Database::pdo()->prepare("
            INSERT INTO properties
                (type, badge, title, location, description, price, price_note, status, created_by, updated_by, created_at, updated_at)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([
            $data['type'],
            $data['badge'],
            $data['title'],
            $data['location'],
            $data['description'],
            $data['price'],
            $data['price_note'],
            $data['status'],
            $userId,
            $userId,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public function updateProperty(int $id, array $data, int $userId): void
    {
        $stmt = Database::pdo()->prepare("
            UPDATE properties
            SET type = ?, badge = ?, title = ?, location = ?, description = ?, price = ?, price_note = ?, status = ?,
                updated_by = ?, updated_at = NOW()
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute([
            $data['type'],
            $data['badge'],
            $data['title'],
            $data['location'],
            $data['description'],
            $data['price'],
            $data['price_note'],
            $data['status'],
            $userId,
            $id,
        ]);
    }

    public function replaceFeatures(int $propertyId, array $features): void
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("DELETE FROM property_features WHERE property_id = ?");
        $stmt->execute([$propertyId]);

        if (!$features) {
            return;
        }

        $insert = $pdo->prepare("
            INSERT INTO property_features (property_id, icon, label, value, sort_order)
            VALUES (?, ?, ?, ?, ?)
        ");
        $order = 1;
        foreach ($features as $f) {
            $insert->execute([
                $propertyId,
                $f['icon'] ?? '',
                $f['label'] ?? '',
                $f['value'] ?? '',
                $order++,
            ]);
        }
    }

    public function clearPrimaryMedia(int $propertyId): void
    {
        $stmt = Database::pdo()->prepare("UPDATE media SET is_primary = 0 WHERE property_id = ?");
        $stmt->execute([$propertyId]);
    }

    public function addMedia(
        int $propertyId,
        string $fileType,
        string $filePath,
        ?string $originalName,
        ?string $mimeType,
        ?int $sizeBytes,
        int $isPrimary,
        int $uploadedBy
    ): void {
        $stmt = Database::pdo()->prepare("
            INSERT INTO media
              (property_id, file_type, file_path, original_name, mime_type, size_bytes, is_primary, uploaded_by, created_at)
            VALUES
              (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $propertyId,
            $fileType,
            $filePath,
            $originalName,
            $mimeType,
            $sizeBytes,
            $isPrimary,
            $uploadedBy,
        ]);
    }

    public function deleteProperty(int $id): void
    {
        $pdo = Database::pdo();
        $pdo->prepare("DELETE FROM favorites WHERE property_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM media WHERE property_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM property_features WHERE property_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM properties WHERE id = ?")->execute([$id]);
    }

    public function listUsers(): array
    {
        return Database::pdo()->query("
            SELECT id, name, email, role, is_active, created_at
            FROM users
            ORDER BY id DESC
        ")->fetchAll();
    }

    public function setUserRole(int $userId, string $role): void
    {
        $stmt = Database::pdo()->prepare("UPDATE users SET role = ?, updated_at = NOW() WHERE id = ? LIMIT 1");
        $stmt->execute([$role, $userId]);
    }

    public function setUserActive(int $userId, bool $active): void
    {
        $stmt = Database::pdo()->prepare("UPDATE users SET is_active = ?, updated_at = NOW() WHERE id = ? LIMIT 1");
        $stmt->execute([$active ? 1 : 0, $userId]);
    }

    public function listFavorites(): array
    {
        $stmt = Database::pdo()->query("
            SELECT f.id, f.created_at,
                   u.id AS user_id, u.name AS user_name, u.email AS user_email,
                   p.id AS property_id, p.title AS property_title
            FROM favorites f
            JOIN users u ON u.id = f.user_id
            JOIN properties p ON p.id = f.property_id
            ORDER BY f.id DESC
        ");
        return $stmt->fetchAll();
    }
}
