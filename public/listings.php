<?php
require_once __DIR__ . '/../app/Repositories/PropertyRepository.php';

$type = $_GET['type'] ?? null;
$repo = new PropertyRepository();
$properties = $repo->getAllActive($type);

// require_once __DIR__ . '/../views/layouts/header.php';
require __DIR__ . '/../views/listings.php';
// require_once __DIR__ . '/../views/layouts/footer.php';