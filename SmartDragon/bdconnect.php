<?php
$host = 'localhost';       
$db   = 'smartdragon';     
$user = 'root';         
$pass = '';     
$charset = 'utf8mb4';     

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

$mysqli->set_charset($charset);
?>
