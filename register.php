<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit;
}
require "db.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = "Enter your name, a valid email, and a password with at least 6 characters.";
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = "That email already has an account. Please log in.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);

            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["user_name"] = $name;
            session_regenerate_id(true);
            header("Location: home.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Diary | Create account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <main class="auth-card">
        <div class="brand-icon">✿</div>
        <p class="eyebrow">YOUR OWN LITTLE CORNER</p>
        <h1>Start your diary</h1>
        <p class="subtitle">Make a little room for your thoughts.</p>

        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <form method="POST" action="register.php">
            <label for="name">Your name</label>
            <input id="name" type="text" name="name" placeholder="What should we call you?" required>

            <label for="email">Email address</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" required>

            <label for="password">Create password</label>
            <input id="password" type="password" name="password" placeholder="At least 6 characters" minlength="6" required>

            <button class="primary-btn" type="submit">Create my diary <span>→</span></button>
        </form>
        <p class="auth-switch">Already have an account? <a href="index.php">Log in</a></p>
    </main>
</body>
</html>