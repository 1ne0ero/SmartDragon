<?php
session_start();
require_once 'bdconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT nickname, fullname, email, role, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nickname, $fullname, $email, $role, $created_at);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("SELECT id, title, description FROM topics WHERE author_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$topics_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Профиль пользователя — SmartDragon</title>
  <link rel="stylesheet" href="style_guides.css" />
  <link rel="stylesheet" href="style_profile.css" />
  <link rel="icon" href="image/dragon_1643150.png" type="image/png" />
</head>
<body>

<header class="top-header">
  <div class="logo-container">
    <img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" />
  </div>
  <div class="site-title">SmartDragon</div>
  <div class="empty-space auth-area">
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
    <a href="official_guides.php" class="nav-link">Официальные гайды</a>
    <a href="user_guides.php" class="nav-link">Гайды от игроков</a>
    <a href="profile.php" class="nav-link active">Профиль</a>
  </div>
</nav>

<main class="profile-main">
  <h2>Профиль пользователя</h2>
  <dl class="profile-info">
    <dt>Ник</dt>
    <dd><?=htmlspecialchars($nickname)?></dd>
    <dt>ФИО</dt>
    <dd><?=htmlspecialchars($fullname)?></dd>
    <dt>E-mail</dt>
    <dd><?=htmlspecialchars($email)?></dd>
    <dt>Роль</dt>
    <dd><?=($role === 'administrator') ? 'Администратор' : 'Пользователь'?></dd>
    <dt>Дата регистрации</dt>
    <dd><?=date("d.m.Y H:i", strtotime($created_at))?></dd>
  </dl>

  <section class="user-topics">
    <h2>Мои темы</h2>
    <?php if ($topics_result->num_rows === 0): ?>
      <p>Вы ещё не создали ни одной темы.</p>
    <?php else: ?>
      <ul class="user-topic-list">
        <?php while ($topic = $topics_result->fetch_assoc()): ?>
          <li>
            <strong><?=htmlspecialchars($topic['title'])?></strong> — 
            <?=htmlspecialchars($topic['description'])?>
            <a href="edit_topic.php?id=<?=intval($topic['id'])?>" class="btn-edit">Редактировать</a>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>
  </section>

</main>

</body>
</html>
