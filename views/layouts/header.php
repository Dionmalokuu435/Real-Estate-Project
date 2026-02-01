<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Real-Estate/public/assets/css/listings-styling.css">
    <link rel="stylesheet" href="/Real-Estate/public/assets/css/details-styling.css">


    <title>
        <?= htmlspecialchars($title ?? 'Real Estate') ?>
    </title>
</head>

<body>

    <section class="section-1">
        <header>
            <h1> NT <span>ZOGU</span></h1>
            <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li><a href="project.html">PROJECT</a></li>
                    <li><a href="../public/pages/contact.html">CONTACT</a></li>
                </ul>
            </nav>
        </header>
    </section>