<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    if (!empty($_SESSION['user_name'])) {
        echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_name']) . "</h1>";
        echo '<p><a href="auth/logout.php">Logout</a></p>';
    } else {
        // Removed the "Hello, World!" header per request — keep login/register links only
        echo '<p><a href="auth/login.php">Login</a> | <a href="auth/register.php">Create account</a></p>';
    }
    ?>
</body>

</html>