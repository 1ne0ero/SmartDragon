<?php
session_start();
require_once 'bdconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'] ?? 'user';

$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    die('Некорректный ID темы.');
}

$stmt = $mysqli->prepare("SELECT author_id, image_path FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$stmt->bind_result($author_id, $image_path);
if (!$stmt->fetch()) {
    $stmt->close();
    die('Тема не найдена.');
}
$stmt->close();

if ($user_role !== 'administrator' && $user_id !== $author_id) {
    die('У вас нет прав на удаление этой темы.');
}

if ($image_path && file_exists($image_path)) {
    unlink($image_path);
}

$stmt = $mysqli->prepare("DELETE FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
if ($stmt->execute()) {
    $stmt->close();
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'official_guides.php'));
    exit;
} else {
    $stmt->close();
    die('Ошибка при удалении темы.');
}
