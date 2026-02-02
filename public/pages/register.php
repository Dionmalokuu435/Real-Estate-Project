<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Services/AuthService.php';

$errors = [];
$old = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    $old['name'] = $name;
    $old['email'] = $email;

    // back-end validation
    if ($name === '' || mb_strlen($name) < 2)
        $errors[] = "Name must be at least 2 chars.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Invalid email.";
    if (strlen($password) < 6)
        $errors[] = "Password must be at least 6 chars.";

    if (!$errors) {
        $auth = new AuthService();
        $res = $auth->register($name, $email, $password);
        if ($res['ok']) {
            header("Location: /REAL-ESTATE-PROJECT/public/login.php?registered=1");
            exit;
        }
        $errors[] = $res['error'] ?? 'Registration failed.';
    }
}

require __DIR__ . '/../views/auth/register.view.php';
