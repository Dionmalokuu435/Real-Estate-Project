<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Services/AuthService.php';

$auth = new AuthService();
$auth->logout();

header("Location: /REAL-ESTATE-PROJECT/public/login.php");
exit;
