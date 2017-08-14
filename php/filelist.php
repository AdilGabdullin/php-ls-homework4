<?php
session_start();
if ($_SESSION['access'] !== 'granted') {
    die;
}
require 'config.php';
$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
$sql = 'SELECT photo FROM users WHERE photo IS NOT NULL';
$result = $dbh->query($sql);
$data = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
