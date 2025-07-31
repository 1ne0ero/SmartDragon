<?php
session_start();

require_once 'bdconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $not_robot = $_POST['not_robot'] ?? '';

    if (!$email || !$password) {
        $_SESSION['error'] = 'Пожалуйста, заполните все обязательные поля.';
        header('Location: login.php');
        exit;
    }

    if (!$not_robot) {
        $_SESSION['error'] = 'Подтвердите, что вы не робот.';
        header('Location: login.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Введите корректный адрес электронной почты.';
        header('Location: login.php');
        exit;
    }

    $stmt = $mysqli->prepare('SELECT id, nickname, password_hash, role FROM users WHERE email = ? LIMIT 1');
    if (!$stmt) {
        $_SESSION['error'] = 'Ошибка сервера. Попробуйте позже.';
        header('Location: login.php');
        exit;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['error'] = 'Пользователь с таким email не найден.';
        $stmt->close();
        header('Location: login.php');
        exit;
    }

    $stmt->bind_result($user_id, $nickname, $password_hash, $role);
    $stmt->fetch();

    if (password_verify($password, $password_hash)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['nickname'] = $nickname;
        $_SESSION['role'] = $role;
        $_SESSION['success'] = "Добро пожаловать, $nickname!";

        $stmt->close();

        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Неверный пароль.';
        $stmt->close();
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
