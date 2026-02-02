<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/auth.css">
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>

            <?php if (!empty($registered)): ?>
                <p style="color:green;margin:10px 0;">Account created. Please login.</p>
            <?php endif; ?>

            <?php foreach (($errors ?? []) as $e): ?>
                <p style="color:#b91c1c;margin:6px 0;">
                    <?= htmlspecialchars($e) ?>
                </p>
            <?php endforeach; ?>

            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="field input">
                    <input type="submit" class="btn" value="Login">
                </div>

                <div class="links">
                    Don't have an account? <a href="/REAL-ESTATE-PROJECT/public/register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>