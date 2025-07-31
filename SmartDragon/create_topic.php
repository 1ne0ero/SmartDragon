<?php
session_start();
require_once 'bdconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';
$title = '';
$description = '';
$content = '';
$imagePath = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$title || !$description || !$content) {
        $error = 'Пожалуйста, заполните все обязательные поля.';
    } else {
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
                $error = "Разрешены только изображения формата JPG, JPEG, PNG, GIF.";
            } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                $error = "Размер файла не должен превышать 2 МБ.";
            } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $error = "Ошибка при загрузке файла.";
            } else {
                $imagePath = 'uploads/topics/' . basename($targetFile);
            }
        }

        if (!$error) {
            $author_id = $_SESSION['user_id'];

            $stmtCheckUser = $mysqli->prepare("SELECT id FROM users WHERE id = ?");
            $stmtCheckUser->bind_param("i", $author_id);
            $stmtCheckUser->execute();
            $stmtCheckUser->store_result();
            if ($stmtCheckUser->num_rows === 0) {
                $error = 'Пользователь не найден в системе, невозможно добавить тему.';
            }
            $stmtCheckUser->close();

            if (!$error) {
                $stmt = $mysqli->prepare("INSERT INTO topics (title, description, content, author_id, image_path) VALUES (?, ?, ?, ?, ?)");

                if ($stmt === false) {
                    $error = 'Ошибка сервера при подготовке запроса.';
                } else {
                    if (!$imagePath) {
                        $imagePathForDb = null;
                    } else {
                        $imagePathForDb = $imagePath;
                    }

                    $stmt->bind_param("sssis", $title, $description, $content, $author_id, $imagePathForDb);
                    if ($stmt->execute()) {
                        $success = 'Тема успешно создана!';
                        $title = $description = $content = '';
                        $imagePath = null;
                    } else {
                        $error = 'Ошибка при сохранении темы. Попробуйте позже.';
                    }
                    $stmt->close();
                }
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
<title>Создать тему — SmartDragon</title>
<link rel="stylesheet" href="style_create_topic.css" />
<link rel="icon" href="image/dragon_1643150.png" type="image/png" />
</head>
<body>

<header class="top-header">
  <div class="logo-container">
    <img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" />
  </div>

  <div class="site-title">SmartDragon</div>

  <div class="empty-space auth-area">
    <button class="btn-create-topic" onclick="location.href='create_topic.php'">Создать тему</button>

    <div class="auth-section">
      <span class="user-nickname"><?=htmlspecialchars($_SESSION['nickname'])?></span>
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
    <a href="create_topic.php" class="nav-link active">Создать тему</a>
  </div>
</nav>

<main class="create-topic">
  <h2>Создать новую тему</h2>

  <?php if ($error): ?>
    <div class="message error"><?=htmlspecialchars($error)?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="message success"><?=htmlspecialchars($success)?></div>
  <?php endif; ?>

  <form action="create_topic.php" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
    <label for="title">Название темы</label>
    <input type="text" id="title" name="title" required value="<?=htmlspecialchars($title)?>" />

    <label for="description">Краткое описание</label>
    <textarea id="description" name="description" rows="3" required><?=htmlspecialchars($description)?></textarea>

    <label for="content">Содержание</label>
    <textarea id="content" name="content" rows="8" required><?=htmlspecialchars($content)?></textarea>

    <label for="image">Изображение к теме (необязательно)</label>
    <input type="file" id="image" name="image" accept="image/*" />

    <button type="submit" class="submit-btn">Создать тему</button>
  </form>
</main>

</body>
</html>
