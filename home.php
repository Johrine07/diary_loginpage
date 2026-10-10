<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
require "db.php";

$stmt = $pdo->prepare("SELECT id, title, content, created_at FROM entries WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION["user_id"]]);
$entries = $stmt->fetchAll();

$notice = $_SESSION["notice"] ?? "";
unset($_SESSION["notice"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Diary | My pages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-page">
    <header class="topbar">
        <a class="wordmark" href="home.php"><span>✿</span> little diary</a>
        <div class="topbar-right">
            <span class="welcome">Hello, <?= htmlspecialchars($_SESSION["user_name"]) ?> ♡</span>
            <a class="logout-link" href="logout.php">Log out ↗</a>
        </div>
    </header>

    <main class="dashboard">
        <section class="welcome-panel">
            <div>
                <p class="eyebrow">YOUR PRIVATE JOURNAL</p>
                <h1>A page for <em>today.</em></h1>
                <p class="subtitle">Collect little moments. Remember how they felt.</p>
            </div>
            <div class="sun-doodle">☼</div>
        </section>

        <?php if ($notice): ?><div class="success"><?= htmlspecialchars($notice) ?></div><?php endif; ?>

        <div class="content-grid">
            <section class="write-card">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">DEAR DIARY,</p>
                        <h2>What's on your mind?</h2>
                    </div>
                    <span class="paperclip">♡</span>
                </div>
                <form action="save_entry.php" method="POST">
                    <label for="title">Entry title</label>
                    <input id="title" name="title" type="text" maxlength="120" placeholder="A little moment..." required>
                    <label for="content">Your thoughts</label>
                    <textarea id="content" name="content" rows="7" placeholder="Write freely. This page is yours..." required></textarea>
                    <button class="primary-btn" type="submit">Save this memory <span>♡</span></button>
                </form>
                <p class="privacy-note">✦ Only entries saved to your account appear here.</p>
            </section>

            <section class="entries-section">
                <div class="entries-heading">
                    <div>
                        <p class="eyebrow">THE MEMORY BOX</p>
                        <h2>My diary pages</h2>
                    </div>
                    <span class="entry-count"><?= count($entries) ?> <?= count($entries) === 1 ? "page" : "pages" ?></span>
                </div>

                <?php if (!$entries): ?>
                    <div class="empty-state">
                        <div class="empty-flower">❀</div>
                        <h3>Your story starts here</h3>
                        <p>Your saved diary pages will appear here. Write your first entry whenever you're ready.</p>
                    </div>
                <?php else: ?>
                    <div class="entry-list">
                        <?php foreach ($entries as $entry): ?>
                            <article class="entry-card">
                                <div class="entry-date"><?= date("F j, Y · g:i A", strtotime($entry["created_at"])) ?></div>
                                <h3><?= htmlspecialchars($entry["title"]) ?></h3>
                                <p class="entry-content"><?= nl2br(htmlspecialchars($entry["content"])) ?></p>
                                <form class="delete-form" action="delete_entry.php" method="POST" onsubmit="return confirm('Delete this diary page?');">
                                    <input type="hidden" name="entry_id" value="<?= (int)$entry["id"] ?>">
                                    <button class="delete-btn" type="submit">Delete page</button>
                                </form>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <footer class="footer-note">Made with a little love, just for your memories ✿</footer>
    </main>
</body>
</html>