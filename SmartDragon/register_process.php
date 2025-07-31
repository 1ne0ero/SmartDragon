<?php
session_start();

require_once 'bdconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $privacy = $_POST['privacy'] ?? '';

    if (!$nickname || !$email || !$password || !$confirm_password) {
        $_SESSION['error'] = 'Пожалуйста, заполните все обязательные поля.';
        header('Location: register.php');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Пароли не совпадают.';
        header('Location: register.php');
        exit;
    }

    if (!$privacy) {
        $_SESSION['error'] = 'Вы должны согласиться с политикой конфиденциальности.';
        header('Location: register.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Неверный формат электронной почты.';
        header('Location: register.php');
        exit;
    }

    $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? OR nickname = ?');
    $stmt->bind_param('ss', $email, $nickname);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = 'Пользователь с таким email или ником уже существует.';
        $stmt->close();
        header('Location: register.php');
        exit;
    }
    $stmt->close();

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
 
    $stmt = $mysqli->prepare('INSERT INTO users (nickname, fullname, email, password_hash, role) VALUES (?, ?, ?, ?, ?)');
    $role = 'user'; 
    $stmt->bind_param('sssss', $nickname, $fullname, $email, $password_hash, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Регистрация прошла успешно. Теперь вы можете войти.';
        $stmt->close();
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['error'] = 'Ошибка регистрации: попробуйте позже.';
        $stmt->close();
        header('Location: register.php');
        exit;
    }
} else {
    header('Location: register.php');
    exit;
}
