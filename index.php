<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit;
}
require "db.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: home.php");
        exit;
    }
    $error = "Incorrect email or password. Please try again.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Diary | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <main class="auth-card">
        <div class="brand-icon">✿</div>
        <p class="eyebrow">A LITTLE SPACE FOR YOU</p>
        <h1>Welcome back</h1>
        <p class="subtitle">Your thoughts are waiting for you.</p>

        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <form method="POST" action="index.php">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Enter your password" required>

            <button class="primary-btn" type="submit">Open my diary <span>→</span></button>
        </form>
        <p class="auth-switch">New to Little Diary? <a href="register.php">Create an account</a></p>
        <p class="tiny-note">A quiet place to keep your everyday memories.</p>
    </main>
</body>
</html>