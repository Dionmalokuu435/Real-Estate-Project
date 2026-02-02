<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Services/AuthService.php';

$errors = [];
$old = ['email' => ''];
$registered = isset($_GET['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $old['email'] = $email;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Invalid email.";
    if ($password === '')
        $errors[] = "Password is required.";

    if (!$errors) {
        $auth = new AuthService();
        $res = $auth->login($email, $password);
        if ($res['ok']) {
            // role-based redirect
            $role = $_SESSION['user']['role'] ?? 'user';
            header("Location: /REAL-ESTATE-PROJECT/public/" . ($role === 'admin' ? "dashboard.php" : "index.php"));
            exit;
        }
        $errors[] = $res['error'] ?? 'Login failed.';
    }
}

require __DIR__ . '/../views/auth/login.view.php';
