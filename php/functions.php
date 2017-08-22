<?php
function checkImage($fileArray, &$extension)
{
    if (is_null($fileArray)) {
        $extension = '';
        return false;
    }
    $acceptableExtensions = ['bmp', 'gif', 'jpg', 'png', 'svg'];
    $maxFileSize = 5;
    $tmp_name = $fileArray['tmp_name'];
    $extension = preg_replace('/.*\./', '', $fileArray['name']);
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
    if (filesize($tmp_name) > $maxFileSize * 1024 ** 2) {
        echo 'Размер файла - не более ' . $maxFileSize . 'МБ';
        die;
    }
    return true;
}

function blowFishHash($s)
{
    return password_hash($s, PASSWORD_BCRYPT, ['salt' => '@W#YG6yYqHA?{S4#Rvx{vn']);
}
