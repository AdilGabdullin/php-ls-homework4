<?php
require_once 'functions.php';
require 'config.php';
$login = $_POST['login'];
$hash = blowFishHash($_POST['password']);
$stmt = $dbh->prepare('SELECT * FROM users WHERE login = ? AND password = ?');
$stmt->execute([$login, $hash]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
if ($record !== false) {
    session_start();
    $_SESSION['access'] = 'granted';
    echo 'Доступ открыт';
} else {
    echo 'Неверные имя пользователя и пароль';
}
