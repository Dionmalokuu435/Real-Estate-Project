<?php
require_once __DIR__ . '/../app/Repositories/PropertyRepository.php';

$type = $_GET['type'] ?? null;
$repo = new PropertyRepository();
$properties = $repo->getAllActive($type);

$favSet = [];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLogged = !empty($_SESSION['user']['id']);

if ($isLogged && !empty($properties)) {
    require_once __DIR__ . '/../app/Repositories/FavoriteRepository.php';
    $favRepo = new FavoriteRepository();
    $ids = array_map(fn($p) => (int) $p['id'], $properties);
    $favSet = $favRepo->getFavoritePropertyIds((int) $_SESSION['user']['id'], $ids);
}


// require_once __DIR__ . '/../views/layouts/header.php';
require __DIR__ . '/../views/listings.php';
// require_once __DIR__ . '/../views/layouts/footer.php';