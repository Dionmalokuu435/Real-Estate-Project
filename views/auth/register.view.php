<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/auth.css">
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>

            <?php foreach (($errors ?? []) as $e): ?>
                <p style="color:#b91c1c;margin:6px 0;">
                    <?= htmlspecialchars($e) ?>
                </p>
            <?php endforeach; ?>

            <form action="" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                        required>
                </div>

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
                    <input type="submit" class="btn" value="Create account">
                </div>

                <div class="links">
                    Already a member? <a href="/REAL-ESTATE-PROJECT/public/login.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>