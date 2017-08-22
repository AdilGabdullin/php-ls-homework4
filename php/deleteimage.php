<?php
session_start();
if ($_SESSION['access'] !== 'granted') {
    die;
}
require 'config.php';
$toDelete = $_GET['delete'];

if (!preg_match('/\d+\.(bmp|gif|jpg|png|svg)/', $toDelete)) {
    echo 'Ошибка. Неверное имя файла';
    die;
}
//Удаляем файл картинки
$query = "UPDATE users SET photo=NULL WHERE photo=?";
$dbh->prepare($query)->execute([$toDelete]);
unlink('../photos/' . $toDelete);
header('Location: /filelist.html');
