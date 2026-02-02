<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Http/AuthMiddleware.php';
require_once __DIR__ . '/../app/Repositories/AdminRepository.php';

AuthMiddleware::requireAdmin();

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$repo = new AdminRepository();
$userId = (int) ($_SESSION['user']['id'] ?? 0);

function jsonOk(array $data = []): void
{
    echo json_encode(['ok' => true] + $data);
    exit;
}

function jsonError(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $message]);
    exit;
}

function safeFilename(string $name): string
{
    $name = basename($name);
    $name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
    if ($name === '' || $name === '.' || $name === '..') {
        $name = 'file';
    }
    return $name;
}

switch ($action) {
    case 'stats':
        jsonOk(['stats' => $repo->getStats()]);
        break;

    case 'recent_properties':
        jsonOk(['items' => $repo->getRecentProperties(5)]);
        break;

    case 'properties':
        jsonOk(['items' => $repo->listProperties()]);
        break;

    case 'property':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            jsonError('Invalid property id');
        }
        $p = $repo->getProperty($id);
        if (!$p) {
            jsonError('Not found', 404);
        }
        jsonOk([
            'property' => $p,
            'features' => $repo->getPropertyFeatures($id),
            'media' => $repo->getPropertyMedia($id),
        ]);
        break;

    case 'save_property':
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string) ($_POST['title'] ?? '')),
            'type' => trim((string) ($_POST['type'] ?? '')),
            'location' => trim((string) ($_POST['location'] ?? '')),
            'price' => (float) ($_POST['price'] ?? 0),
            'price_note' => trim((string) ($_POST['price_note'] ?? '')),
            'status' => trim((string) ($_POST['status'] ?? 'active')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'badge' => trim((string) ($_POST['badge'] ?? '')),
        ];

        if ($data['title'] === '' || $data['type'] === '' || $data['location'] === '' || $data['price'] <= 0) {
            jsonError('Missing required fields');
        }

        if (!in_array($data['status'], ['active', 'inactive'], true)) {
            $data['status'] = 'active';
        }

        if (!in_array($data['type'], ['house', 'apartment', 'land', 'commercial'], true)) {
            jsonError('Invalid property type');
        }

        $features = [];
        if (!empty($_POST['features'])) {
            $decoded = json_decode((string) $_POST['features'], true);
            if (is_array($decoded)) {
                $features = $decoded;
            }
        }

        if ($id > 0) {
            $existing = $repo->getProperty($id);
            if (!$existing) {
                jsonError('Not found', 404);
            }
            if ($data['badge'] === '') {
                $data['badge'] = (string) ($existing['badge'] ?? '');
            }
            $repo->updateProperty($id, $data, $userId);
            $repo->replaceFeatures($id, $features);
            $propertyId = $id;
        } else {
            $propertyId = $repo->createProperty($data, $userId);
            $repo->replaceFeatures($propertyId, $features);
        }

        $markPrimary = (int) ($_POST['mark_primary'] ?? 0) === 1;
        if ($markPrimary) {
            $repo->clearPrimaryMedia($propertyId);
        }

        $uploadDir = __DIR__ . "/uploads/properties/{$propertyId}";
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
            $count = count($_FILES['images']['name']);
            for ($i = 0; $i < $count; $i++) {
                $tmp = $_FILES['images']['tmp_name'][$i] ?? '';
                if (!is_uploaded_file($tmp)) {
                    continue;
                }
                $orig = $_FILES['images']['name'][$i] ?? 'image';
                $mime = $_FILES['images']['type'][$i] ?? null;
                $size = isset($_FILES['images']['size'][$i]) ? (int) $_FILES['images']['size'][$i] : null;
                $safe = safeFilename($orig);
                $name = time() . '_' . $i . '_' . $safe;
                $target = $uploadDir . '/' . $name;
                if (move_uploaded_file($tmp, $target)) {
                    $isPrimary = ($markPrimary && $i === 0) ? 1 : 0;
                    $relPath = "uploads/properties/{$propertyId}/{$name}";
                    $repo->addMedia($propertyId, 'image', $relPath, $orig, $mime, $size, $isPrimary, $userId);
                }
            }
        }

        if (!empty($_FILES['brochure']) && is_uploaded_file($_FILES['brochure']['tmp_name'])) {
            $orig = $_FILES['brochure']['name'] ?? 'brochure.pdf';
            $mime = $_FILES['brochure']['type'] ?? null;
            $size = isset($_FILES['brochure']['size']) ? (int) $_FILES['brochure']['size'] : null;
            $safe = safeFilename($orig);
            $name = time() . '_' . $safe;
            $target = $uploadDir . '/' . $name;
            if (move_uploaded_file($_FILES['brochure']['tmp_name'], $target)) {
                $relPath = "uploads/properties/{$propertyId}/{$name}";
                $repo->addMedia($propertyId, 'pdf', $relPath, $orig, $mime, $size, 0, $userId);
            }
        }

        jsonOk(['id' => $propertyId]);
        break;

    case 'delete_property':
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            jsonError('Invalid id');
        }
        $repo->deleteProperty($id);
        jsonOk();
        break;

    case 'users':
        jsonOk(['items' => $repo->listUsers()]);
        break;

    case 'update_user_role':
        $id = (int) ($_POST['id'] ?? 0);
        $role = (string) ($_POST['role'] ?? 'user');
        if (!in_array($role, ['admin', 'user'], true)) {
            jsonError('Invalid role');
        }
        if ($id <= 0) {
            jsonError('Invalid id');
        }
        $repo->setUserRole($id, $role);
        jsonOk();
        break;

    case 'set_user_active':
        $id = (int) ($_POST['id'] ?? 0);
        $active = (int) ($_POST['active'] ?? 0) === 1;
        if ($id <= 0) {
            jsonError('Invalid id');
        }
        $repo->setUserActive($id, $active);
        jsonOk();
        break;

    case 'favorites':
        jsonOk(['items' => $repo->listFavorites()]);
        break;

    default:
        jsonError('Unknown action');
}
