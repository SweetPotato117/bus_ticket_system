<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-screen">
        <div class="login-content">
            <!-- optional logo: place a logo.png next to this file for branding -->
            <img src="logo.png" alt="Logo" class="logo" loading="lazy" onerror="this.style.display='none'" />

            <img src="../assets/logo.png" alt="App Logo" class="logo">


            <h1 class="app-title">Bus Reservation</h1>
            <p class="app-subtitle">Sign in to continue</p>

            <?php if (!empty($_SESSION['auth_message'])): ?>
                <p class="message"><?php echo htmlspecialchars($_SESSION['auth_message']); unset($_SESSION['auth_message']); ?></p>
            <?php endif; ?>

            <form class="login-form" method="post" action="process_login.php">
                <input class="input-field" id="name" name="name" placeholder="Username" required />

                <input class="input-field" id="password" name="password" type="password" placeholder="Password" required />

                <button class="login-button" type="submit">Login</button>
            </form>

            <a class="forgot-password" href="#">Forgot password?</a>
            <p class="muted-link">No account? <a href="register.php">Create one</a></p>
        </div>
    </div>
</body>
</html>
