<?php
require 'config.php';
$acceptableExtensions = ['bmp', 'gif', 'jpg', 'png', 'svg'];
define('MAX_FILE_SIZE', 5);

$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);

// Проверка уникальности
$stmt = $dbh->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
$stmt->execute([$_POST['login']]);
$count = $stmt->fetch(PDO::FETCH_NUM)[0];
if ($count[0] !== '0') {
    echo 'Имя пользователя уже существует';
    die;
}
// Проверка на опечатку в пароле
if ($_POST['password1'] !== $_POST['password2']) {
    echo 'Пароли не совпадают';
    die;
}
//Проверка картинки
if (!is_null($_FILES['img'])) {
    $tmp_name = $_FILES['img']['tmp_name'];
    $extension = preg_replace('/.*\./', '', $_FILES['img']['name']);
    $extension = strtolower($extension);
    if (!in_array($extension, $acceptableExtensions)) {
        echo 'Неверное расширение файла';
        die;
    }
    $type = mime_content_type($tmp_name);
    if (substr($type, 0, 5) !== 'image') {
        echo 'Это не картинка!!!';
        die;
    }
    if (filesize($tmp_name) > MAX_FILE_SIZE * 1024 ** 2) {
        echo 'Размер файла - не более ' . MAX_FILE_SIZE . 'МБ';
        die;
    }
    $imageSent = true;
} else {
    //Картинка не отправлена
    $extension = null;
    $imageSent = false;
}

//Добавляем нового пользователя
$query = <<<'EOL'
INSERT INTO users
(login, password, name, age, description)
VALUES(?, ?, ?, ?, ?);
EOL;
$values = [
    strip_tags($_POST['login']),
    password_hash($_POST['password1'], PASSWORD_BCRYPT),
    strip_tags($_POST['name']),
    filter_var($_POST['age'], FILTER_VALIDATE_INT),
    htmlspecialchars($_POST['description'])
];
$dbh->prepare($query)->execute($values);

//Сохраняем в папку, добавляем имя файла в базу
if ($imageSent) {
    $lastId = $dbh->lastInsertId();
    $filename = "$lastId.$extension";
    $destination = '../photos/' . $filename;
    $tmp_name = $_FILES['img']['tmp_name'];
    $query = "UPDATE users SET photo='$filename' WHERE id=$lastId";
    $dbh->query($query);
    move_uploaded_file($tmp_name, $destination);
}
echo 'Регистрация прошла успешно';
