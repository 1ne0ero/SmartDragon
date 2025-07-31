<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'bdconnect.php';

$nickname = $_SESSION['nickname'] ?? 'Пользователь';
$role = $_SESSION['role'] ?? 'user';
$user_id = $_SESSION['user_id'] ?? 0;

$sql = "
    SELECT t.id, t.title, t.description, t.image_path, t.author_id
    FROM topics t
    JOIN users u ON t.author_id = u.id
    WHERE u.role = 'administrator'
    ORDER BY t.created_at DESC
";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die('Ошибка подготовки запроса.');
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SmartDragon — Официальные гайды</title>
<link rel="stylesheet" href="style_guides.css" />
<link rel="icon" href="image/dragon_1643150.png" type="image/png" />
</head>

<body>
<header class="top-header">
    <div class="logo-container">
        <img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" />
    </div>

    <div class="site-title">SmartDragon</div>

    <div class="empty-space auth-area">
        <?php if ($role === 'administrator'): ?>
            <button class="btn-create-topic" onclick="location.href='create_topic.php'">Создать тему</button>
        <?php endif; ?>

        <div class="auth-section">
            <a href="profile.php" class="user-nickname-link"><?=htmlspecialchars($nickname)?></a>
            <form action="logout.php" method="post" class="logout-form" style="margin:0;">
                <button type="submit" class="logout-btn">Выйти</button>
            </form>
        </div>
    </div>
</header>

<nav class="sub-header">
    <div class="nav-links">
        <a href="official_guides.php" class="nav-link active">Официальные гайды</a>
        <a href="user_guides.php" class="nav-link">Гайды от игроков</a>
    </div>
</nav>

<main class="content">
    <h1>Официальные гайды</h1>
    <div class="topic-cards-container">
        <?php while ($topic = $result->fetch_assoc()): ?>
            <?php 
                $isAuthor = ($user_id === intval($topic['author_id']));
                $isAdmin = ($role === 'administrator');
                $isAuthorOrAdmin = $isAdmin || $isAuthor;
            ?>
            <div class="topic-card" tabindex="0">
                <?php if ($topic['image_path']): ?>
                    <div class="topic-image-wrapper">
                        <img src="<?=htmlspecialchars($topic['image_path'])?>" alt="<?=htmlspecialchars($topic['title'])?>" class="topic-image" />
                    </div>
                <?php endif; ?>
                <div class="topic-content">
                    <h3 class="topic-title"><?=htmlspecialchars($topic['title'])?></h3>
                    <p class="topic-description"><?=htmlspecialchars($topic['description'])?></p>

                    <div class="topic-buttons-row">
                        <a href="topic.php?id=<?=intval($topic['id'])?>" class="btn-go">Перейти</a>
                        <?php if ($isAdmin || $isAuthor): ?>
                            <a href="delete_topic.php?id=<?=intval($topic['id'])?>" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить эту тему?');">Удалить</a>
                        <?php endif; ?>
                    </div>

                    <?php if ($isAuthor): ?>
                        <div class="topic-buttons-edit">
                            <a href="edit_topic.php?id=<?=intval($topic['id'])?>" class="btn-edit">Редактировать</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>
</body>
</html>
