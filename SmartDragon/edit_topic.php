<?php
session_start();
require_once 'bdconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    die('Некорректный ID темы.');
}

// Получаем тему и проверяем права
$stmt = $mysqli->prepare("SELECT title, description, content, image_path, author_id FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$stmt->bind_result($title, $description, $content, $image_path, $author_id);
if (!$stmt->fetch()) {
    $stmt->close();
    die('Тема не найдена.');
}
$stmt->close();

if ($user_id !== $author_id) {
    die('У вас нет прав на редактирование этой темы.');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = trim($_POST['title'] ?? '');
    $newDescription = trim($_POST['description'] ?? '');
    $newContent = trim($_POST['content'] ?? '');
    $newImagePath = $image_path;

    if (!$newTitle || !$newDescription || !$newContent) {
        $error = 'Пожалуйста, заполните все обязательные поля.';
    } else {
        // Если выбрано новое изображение
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/topics/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = basename($_FILES['image']['name']);
            $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);
            $uniquePrefix = time() . '_' . bin2hex(random_bytes(5));
            $targetFile = $uploadDir . $uniquePrefix . '_' . $fileName;

            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileType, $allowedTypes)) {
                $error = "Разрешены только изображения JPG, JPEG, PNG, GIF.";
            } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                $error = "Размер файла не должен превышать 2 МБ.";
            } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $error = "Ошибка при загрузке файла.";
            } else {
                if ($image_path && file_exists(__DIR__ . '/' . $image_path)) {
                    unlink(__DIR__ . '/' . $image_path);
                }
                $newImagePath = 'uploads/topics/' . basename($targetFile);
            }
        }

        if (!$error) {
            $stmtUpdate = $mysqli->prepare("UPDATE topics SET title = ?, description = ?, content = ?, image_path = ? WHERE id = ?");
            if ($stmtUpdate) {
                $stmtUpdate->bind_param("ssssi", $newTitle, $newDescription, $newContent, $newImagePath, $topic_id);
                if ($stmtUpdate->execute()) {
                    $success = 'Тема успешно обновлена!';
                    $title = $newTitle;
                    $description = $newDescription;
                    $content = $newContent;
                    $image_path = $newImagePath;
                } else {
                    $error = 'Ошибка при сохранении изменений.';
                }
                $stmtUpdate->close();
            } else {
                $error = 'Ошибка сервера.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Редактировать тему — SmartDragon</title>
<link rel="stylesheet" href="style_create_topic.css" />
</head>
<body>
<header class="top-header">
  <div class="logo-container">
    <a href="official_guides.php" title="На главную">
      <img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" />
    </a>
  </div>
  <div class="site-title">SmartDragon</div>
  <div class="empty-space auth-area">
    <div class="auth-section">
      <a href="profile.php" class="user-nickname-link"><?=htmlspecialchars($_SESSION['nickname'])?></a>
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
    <a href="edit_topic.php?id=<?=intval($topic_id)?>" class="nav-link active">Редактировать тему</a>
  </div>
</nav>
<main class="create-topic">
  <h2>Редактировать тему</h2>
  <?php if ($error): ?>
    <div class="message error"><?=htmlspecialchars($error)?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="message success"><?=htmlspecialchars($success)?></div>
  <?php endif; ?>
  <form action="edit_topic.php?id=<?=intval($topic_id)?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
    <label for="title">Название темы</label>
    <input type="text" id="title" name="title" required value="<?=htmlspecialchars($title)?>" />

    <label for="description">Краткое описание</label>
    <textarea id="description" name="description" rows="3" required><?=htmlspecialchars($description)?></textarea>

    <label for="content">Содержание</label>
    <textarea id="content" name="content" rows="8" required><?=htmlspecialchars($content)?></textarea>

    <?php if ($image_path): ?>
      <p>Текущее изображение:</p>
      <img src="<?=htmlspecialchars($image_path)?>" alt="Текущее изображение" style="max-width: 300px; display: block; margin-bottom:15px;" />
    <?php endif; ?>

    <label for="image">Заменить изображение (необязательно)</label>
    <input type="file" id="image" name="image" accept="image/*" />

    <button type="submit" class="submit-btn">Сохранить изменения</button>
  </form>
</main>
</body>
</html>
