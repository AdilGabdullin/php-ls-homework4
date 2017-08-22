<?php
session_start();
if ($_SESSION['access'] !== 'granted') {
    die;
}
require 'config.php';
$toDelete = $_GET['delete'];
//Удаляем файл картинки
$query = "SELECT photo FROM users WHERE id = ?";
$stmt = $dbh->prepare($query);
$stmt->execute([$toDelete]);
$result = $stmt->fetch(pdo::FETCH_ASSOC);
if ($result['photo'] != '') {
    unlink('../photos/' . $result['photo']);
}
//Удаляем запись из базы
$query = "DELETE FROM users WHERE id = ?";
$dbh->prepare($query)->execute([$toDelete]);
header('Location: /list.html');
