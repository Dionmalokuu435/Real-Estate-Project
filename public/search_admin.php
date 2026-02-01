<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=real_estate;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$name = "Admin";
$email = "admin@example.com";
$pass = "Dion123!";
$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?, 'admin')");
$stmt->execute([$name, $email, $hash]);

echo "OK: $email / $pass";
