<?php
session_start();
require_once 'bdconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    die('Некорректный ID темы.');
}

$stmt = $mysqli->prepare("SELECT title, description, content, image_path, created_at FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$stmt->bind_result($title, $description, $content, $image_path, $created_at);
if (!$stmt->fetch()) {
    $stmt->close();
    die('Тема не найдена.');
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?=htmlspecialchars($title)?> — SmartDragon</title>
    <link rel="stylesheet" href="style_guides.css" />
    <link rel="stylesheet" href="style_profile.css" />
    <link rel="stylesheet" href="style_topic.css" />
    <link rel="icon" href="image/dragon_1643150.png" type="image/png" />
</head>
<body>
<header class="top-header">
    <div class="logo-container">
        <a href="official_guides.php" title="На главную"><img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" /></a>
    </div>
    <div class="site-title">SmartDragon</div>
    <div class="empty-space auth-area">
        <?php if (isset($_SESSION['nickname'])): ?>
            <div class="auth-section">
                <a href="profile.php" class="user-nickname-link"><?=htmlspecialchars($_SESSION['nickname'])?></a>
                <form action="logout.php" method="post" class="logout-form" style="margin:0;">
                    <button type="submit" class="logout-btn">Выйти</button>
                </form>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login">Войти</a>
        <?php endif; ?>
    </div>
</header>

<nav class="sub-header">
    <div class="nav-links">
        <a href="official_guides.php" class="nav-link">Официальные гайды</a>
        <a href="user_guides.php" class="nav-link">Гайды от игроков</a>
    </div>
</nav>

<main class="topic-page">
    <h1><?=htmlspecialchars($title)?></h1>
    <?php if ($image_path): ?>
        <img src="<?=htmlspecialchars($image_path)?>" alt="<?=htmlspecialchars($title)?>" class="topic-image" />
    <?php endif; ?>
    <p class="topic-description"><em><?=htmlspecialchars($description)?></em></p>
    <div class="topic-content"><?=nl2br(htmlspecialchars($content))?></div>
    <p class="topic-date">Дата создания: <?=date("d.m.Y H:i", strtotime($created_at))?></p>
</main>

</body>
</html>
