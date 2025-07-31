<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SmartDragon — Вход</title>
<link rel="stylesheet" href="style_auth.css" />
<link rel="icon" href="image/dragon_1643150.png" type="image/png" />
</head>
<body>
  <header class="top-header">
    <div class="logo-container">
      <img src="image/dragon_1643150.png" alt="SmartDragon логотип" class="logo" />
    </div>
    <div class="site-title">SmartDragon</div>
    <div class="empty-space"></div>
  </header>

  <nav class="sub-header">
    <div class="nav-links">
      <a href="official_guides.php" class="nav-link">Официальные гайды</a>
      <a href="user_guides.php" class="nav-link">Гайды от игроков</a>
    </div>
    <div class="auth-buttons">
      <button class="auth-btn active">Вход</button>
      <button class="auth-btn register" onclick="location.href='register.php'">Регистрация</button>
    </div>
  </nav>

  <main class="auth-container">
    <form class="auth-form" action="login_process.php" method="post" autocomplete="off" novalidate>
      <h2>Вход</h2>

      <?php
      if (!empty($_SESSION['error'])) {
          echo '<div class="error-msg">' . htmlspecialchars($_SESSION['error']) . '</div>';
          unset($_SESSION['error']);
      }
      if (!empty($_SESSION['success'])) {
          echo '<div class="success-msg">' . htmlspecialchars($_SESSION['success']) . '</div>';
          unset($_SESSION['success']);
      }
      ?>

      <label for="email">Введите адрес электронной почты</label>
      <input type="email" id="email" name="email" required autocomplete="email" />

      <label for="password">Пароль</label>
      <input type="password" id="password" name="password" required autocomplete="current-password" />

      <div class="checkbox-group">
        <input type="checkbox" id="not-robot" name="not_robot" required />
        <label for="not-robot">Я не робот</label>
      </div>

      <button type="submit" class="submit-btn">Вход</button>

      <p class="no-account-text">
        Нет аккаунта? 
        <a href="register.php" class="link-register">Зарегистрироваться?</a>
      </p>
    </form>
  </main>
</body>
</html>
