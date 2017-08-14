<?php
session_start();
if ($_SESSION['access'] !== 'granted') {
    die;
}
require 'config.php';
$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
$toDelete = $_GET['delete'];
//Удаляем файл картинки
$query = "UPDATE users SET photo=NULL WHERE photo=?";
$dbh->prepare($query)->execute([$toDelete]);
unlink('../photos/' . $toDelete);
echo <<<EOD
<html>
  <head>
    <meta http-equiv='Refresh' content='0; URL="{$_SERVER['HTTP_REFERER']}"'>
  </head>
</html>
EOD;
