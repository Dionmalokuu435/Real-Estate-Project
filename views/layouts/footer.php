<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Real-Estate/public/assets/css/style.css">
    <title>
        <?= htmlspecialchars($title ?? 'Real Estate') ?>
    </title>
</head>

<body>
    <footer>
        <div class="footer">
            <div class="footer-contact">
                <div class="footersection about">
                    <h1 class="logo"><span>NT</span>ZOGU</h1>
                    <p>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                        cupidatat non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>

                    <div class="contact">
                        <span>&number; 012-345-678</span><br>
                        <span>&email; info@ntzogu.com</span>

                        <div class="socials">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-gmail"></i></a>
                        </div>
                    </div>
                </div>

                <div class="footersection links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Gallery</a></li>
                        <li><a href="#">Terms and Condition</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2024 NT ZOGU. All rights reserved.</p>
            </div>
        </div>
    </footer>