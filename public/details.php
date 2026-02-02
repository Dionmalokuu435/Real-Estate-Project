<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Repositories/PropertyRepository.php';

$repo = new PropertyRepository();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(404);
    echo "Property not found";
    exit;
}

$property = $repo->getById($id);
if (!$property) {
    http_response_code(404);
    echo "Property not found";
    exit;
}

$details = $repo->getDetails($id);
$media = $repo->getMedia($id);

$title = $property['title'];
// require __DIR__ . '/../views/layouts/header.php';
require __DIR__ . '/../views/details.php';
// require __DIR__ . '/../views/layouts/footer.php';
