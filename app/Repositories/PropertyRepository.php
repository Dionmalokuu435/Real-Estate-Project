<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

final class PropertyRepository
{
    public function getAllActive(?string $type = null): array
    {
        $params = [];
        $where = "p.status = 'active'";

        if ($type && in_array($type, ['house', 'apartment', 'land'], true)) {
            $where .= " AND p.type = ?";
            $params[] = $type;
        }

        $sql = "
      SELECT p.*,
        (SELECT m.file_path
         FROM media m
         WHERE m.property_id = p.id AND m.is_primary = 1
         ORDER BY m.id DESC
         LIMIT 1) AS primary_image
      FROM properties p
      WHERE {$where}
      ORDER BY p.id DESC
    ";

        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);
        $properties = $stmt->fetchAll();

        if (!$properties)
            return [];

        $ids = array_map(fn($r) => (int) $r['id'], $properties);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt2 = Database::pdo()->prepare("
      SELECT property_id, icon, label, value, sort_order
      FROM property_features
      WHERE property_id IN ($placeholders)
      ORDER BY property_id ASC, sort_order ASC, id ASC
    ");
        $stmt2->execute($ids);
        $rows = $stmt2->fetchAll();

        $map = [];
        foreach ($rows as $row) {
            $pid = (int) $row['property_id'];
            $map[$pid][] = [
                'icon' => $row['icon'],
                'label' => $row['label'],
                'value' => $row['value'],
            ];
        }

        foreach ($properties as &$p) {
            $pid = (int) $p['id'];
            $p['features'] = array_slice($map[$pid] ?? [], 0, 4);
        }
        unset($p);

        return $properties;
    }

    public function getById(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM properties WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $p = $stmt->fetch();
        return $p ?: null;
    }

    public function getDetails(int $propertyId): array
    {
        $stmt = Database::pdo()->prepare("
        SELECT icon, label, value
        FROM property_features
        WHERE property_id = ?
        ORDER BY sort_order ASC, id ASC 
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public function getMedia(int $propertyId): array
    {
        $stmt = Database::pdo()->prepare("
        SELECT id, file_type, file_path, is_primary
        FROM media
        WHERE property_id = ?
        ORDER BY is_primary DESC, id ASC
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public function getLatestActive(int $limit = 6): array
    {
        $limit = max(1, min($limit, 24));

        $sql = "
      SELECT p.*,
        (SELECT m.file_path
         FROM media m
         WHERE m.property_id = p.id AND m.is_primary = 1
         ORDER BY m.id DESC
         LIMIT 1) AS primary_image
      FROM properties p
      WHERE p.status = 'active'
      ORDER BY p.id DESC
      LIMIT {$limit}
    ";

        $properties = Database::pdo()->query($sql)->fetchAll();
        if (!$properties)
            return [];

        $ids = array_map(fn($r) => (int) $r['id'], $properties);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt2 = Database::pdo()->prepare("
      SELECT property_id, icon, label, value, sort_order
      FROM property_features
      WHERE property_id IN ($placeholders)
      ORDER BY property_id ASC, sort_order ASC, id ASC
    ");
        $stmt2->execute($ids);
        $rows = $stmt2->fetchAll();

        $map = [];
        foreach ($rows as $row) {
            $pid = (int) $row['property_id'];
            $map[$pid][] = [
                'icon' => $row['icon'],
                'label' => $row['label'],
                'value' => $row['value'],
            ];
        }

        foreach ($properties as &$p) {
            $pid = (int) $p['id'];
            $p['features'] = array_slice($map[$pid] ?? [], 0, 4);
        }
        unset($p);

        return $properties;
    }


}
