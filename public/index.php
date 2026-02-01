<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Repositories/PropertyRepository.php';

$repo = new PropertyRepository();
$latest = $repo->getLatestActive(6);

require_once __DIR__ . '/../views/layouts/header.php';
require __DIR__ . '/../views/home.php';
require_once __DIR__ . '/../views/layouts/footer.php';
