<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
require "db.php";

$entryId = filter_input(INPUT_POST, "entry_id", FILTER_VALIDATE_INT);
if ($entryId) {
    // The user_id condition prevents deleting another user's diary entry.
    $stmt = $pdo->prepare("DELETE FROM entries WHERE id = ? AND user_id = ?");
    $stmt->execute([$entryId, $_SESSION["user_id"]]);
    $_SESSION["notice"] = $stmt->rowCount() ? "Diary page deleted." : "That page could not be found.";
}
header("Location: home.php");
exit;
?>