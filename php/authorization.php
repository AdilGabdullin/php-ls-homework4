<?php
require 'config.php';
$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
$login = $_POST['login'];
$password = $_POST['password'];
$stmt = $dbh->prepare("SELECT * FROM users WHERE login = ?");
$stmt->execute([$login]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
$hash = $record['password'];
if (password_verify($password, $hash)) {
    session_start();
    $_SESSION['access']='granted';
    echo 'Доступ открыт';
} else {
    echo 'Неверные имя пользователя и пароль';
}
