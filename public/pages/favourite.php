<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Http/AuthMiddleware.php';
require_once __DIR__ . '/../app/Repositories/FavoriteRepository.php';

AuthMiddleware::requireAuth();

header('Content-Type: application/json');

$userId = (int) ($_SESSION['user']['id'] ?? 0);
$propertyId = (int) ($_POST['property_id'] ?? 0);

if ($propertyId <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false]);
    exit;
}

$repo = new FavoriteRepository();

if ($repo->isFavorite($userId, $propertyId)) {
    $repo->remove($userId, $propertyId);
    echo json_encode(['ok' => true, 'favorited' => false, 'is_favorite' => false]);
} else {
    $repo->add($userId, $propertyId);
    echo json_encode(['ok' => true, 'favorited' => true, 'is_favorite' => true]);
}
