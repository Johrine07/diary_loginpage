<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
require "db.php";

$title = trim($_POST["title"] ?? "");
$content = trim($_POST["content"] ?? "");

if ($title !== "" && $content !== "") {
    $stmt = $pdo->prepare("INSERT INTO entries (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION["user_id"], $title, $content]);
    $_SESSION["notice"] = "Your diary page has been saved. ♡";
} else {
    $_SESSION["notice"] = "Please add a title and your thoughts before saving.";
}
header("Location: home.php");
exit;
?>