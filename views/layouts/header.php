<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$isLogged = !empty($user);
$isAdmin = $isLogged && (($user['role'] ?? '') === 'admin');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/style.css">
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/listings-styling.css">
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/details-styling.css">


    <title>
        <?= htmlspecialchars($title ?? 'Real Estate') ?>
    </title>
</head>

<?php
$bodyClassAttr = '';
if (!empty($bodyClass)) {
    $bodyClassAttr = ' class="' . htmlspecialchars($bodyClass) . '"';
}
?>

<body<?= $bodyClassAttr ?>>

    <section class="section-1">
        <header>
            <h1> NT <span>ZOGU</span></h1>
            <nav>
                <ul>
                    <li><a href="/Real-Estate-Project/public/index.php">HOME</a></li>
                    <li><a href="/Real-Estate-Project/public/about.php">ABOUT</a></li>
                    <li><a href="/Real-Estate-Project/public/project.php">PROJECT</a></li>
                    <li><a href="/Real-Estate-Project/public/contact.php">CONTACT</a></li>

                    <?php if ($isAdmin): ?>
                        <li><a href="/Real-Estate-Project/public/dashboard.php">DASHBOARD</a></li>
                    <?php endif; ?>

                    <?php if (!$isLogged): ?>
                        <li><a href="/Real-Estate-Project/public/login.php">LOGIN</a></li>
                        <li><a href="/Real-Estate-Project/public/register.php">SIGN UP</a></li>
                    <?php else: ?>
                        <li style="opacity:.9;">
                            <a href="#" onclick="return false;">
                                <?= htmlspecialchars($user['name'] ?? 'User') ?>
                            </a>
                        </li>
                        <li><a href="/Real-Estate-Project/public/logout.php">LOGOUT</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
    </section>
