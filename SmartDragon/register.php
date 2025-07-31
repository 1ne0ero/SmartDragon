<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SmartDragon — Регистрация</title>
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
      <button class="auth-btn" onclick="location.href='login.php'">Вход</button>
      <button class="auth-btn register active">Регистрация</button>
    </div>
  </nav>

  <main class="auth-container">
    <form class="auth-form" action="register_process.php" method="post" autocomplete="off" novalidate>
      <h2>Регистрация</h2>

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

      <label for="nickname">Введите ваш ник</label>
      <input type="text" id="nickname" name="nickname" required autocomplete="username" />

      <label for="fullname">Введите имя и фамилию (необязательно)</label>
      <input type="text" id="fullname" name="fullname" autocomplete="name" />

      <label for="email">Введите адрес электронной почты</label>
      <input type="email" id="email" name="email" required autocomplete="email" />

      <label for="password">Пароль</label>
      <input type="password" id="password" name="password" required autocomplete="new-password" />

      <label for="confirm-password">Подтвердите пароль</label>
      <input type="password" id="confirm-password" name="confirm_password" required autocomplete="new-password" />

      <div class="checkbox-group">
        <input type="checkbox" id="privacy" name="privacy" required />
        <label for="privacy">
          Я согласен с <a href="privacy_policy.php" target="_blank">политикой конфиденциальности</a>
        </label>
      </div>

      <button type="submit" class="submit-btn">Зарегистрироваться</button>

      <p class="no-account-text">
        Уже есть аккаунт? 
        <a href="login.php" class="link-register">Войти</a>
      </p>
    </form>
  </main>
</body>
</html>
