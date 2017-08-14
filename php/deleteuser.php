<?php
session_start();
if ($_SESSION['access'] !== 'granted') {
    die;
}
require 'config.php';
$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
$toDelete = $_GET['delete'];
//Удаляем файл картинки
$query = "SELECT photo FROM users WHERE id = ?";
$stmt = $dbh->prepare($query);
$stmt->execute([$toDelete]);
$result = $stmt->fetch(pdo::FETCH_ASSOC);
unlink('../photos/' . $result['photo']);
//Удаляем запись из базы
$query = "DELETE FROM users WHERE id = ?";
$dbh->prepare($query)->execute([$toDelete]);
echo <<<EOD
<html>
  <head>
    <meta http-equiv='Refresh' content='0; URL="{$_SERVER['HTTP_REFERER']}"'>
  </head>
</html>
EOD;
