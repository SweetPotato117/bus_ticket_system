<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Account</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-screen">
        <div class="login-content">
            <img src="logo.png" alt="Logo" class="logo" loading="lazy" onerror="this.style.display='none'" />

            <img src="../assets/logo.png" alt="App Logo" class="logo">


            <h1 class="app-title">Create Account</h1>

            <?php if (!empty($_SESSION['auth_message'])): ?>
                <p class="message"><?php echo htmlspecialchars($_SESSION['auth_message']); unset($_SESSION['auth_message']); ?></p>
            <?php endif; ?>

            <form class="login-form" method="post" action="process_register.php">

                <input class="input-field" id="name" name="name" placeholder="Username" required />

                <input class="input-field" id="password" name="password" type="password" placeholder="Password" required />

                <input class="input-field" id="password_confirm" name="password_confirm" type="password" placeholder="Confirm password" required />

                <button class="login-button" type="submit">Create account</button>
            </form>

            <p class="muted-link">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
