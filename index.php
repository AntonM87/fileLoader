<?php
require_once "lib.php";

session_start();

$result ??= null;
$fileNameArr ??= [];
$extension = ['pdf', 'torrent', 'jpg'];

if (isset($_FILES['userFile'])) {
    //загружен ли файл?
    foreach ($_FILES['userFile']['tmp_name'] as $file) {
        isUpload($file);
    }

//проверка размера файла
    foreach ($_FILES['userFile']['size'] as $size) {
        sizeValidation($size, 5);
    }

//Проверка разширения файла
    foreach ($_FILES['userFile']['name'] as $name) {
        extensionValidation($name, $extension);

    }
//проверка наличия директории соответственно расширению файла
    foreach ($_FILES['userFile']['name'] as $key => $name) {
        $fileExtensions = explode('.', $name);
        $pathDir = $_SERVER['DOCUMENT_ROOT'] . '/test/upload/';
        $absolutPathDir = $pathDir . $fileExtensions[(count($fileExtensions) - 1)];

        if (!is_dir($absolutPathDir)) mkdir($absolutPathDir);

        //поиск дубликатов
        //searchDuplicates($name,$absolutPathDir);

        //копирование файла в директорию
        $tmpFile = $_FILES['userFile']['tmp_name'][$key];
        $newNameFile = $_FILES['userFile']['name'][$key];
        array_push($fileNameArr, $newNameFile);
        if (copy($tmpFile, ($absolutPathDir . '/' . $newNameFile))) {
            $result .= "$newNameFile - <strong>Loading complete</strong><br>";
        }
    }
}
//установка источника для индекса
$_SESSION['origin'] = 'index';
$_SESSION['fileNameArr'] = $fileNameArr;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Загрузите ваш файл на сервер</h2>
    <p>Возможные рacширения файлов:</p><?php
    echo "<strong>";
    foreach ($extension as $v){
        echo "$v, ";
    }
    echo "</strong>"
    ?>
    <form action="action.php" method="POST" enctype="multipart/form-data">
        <input multiple name="userFile[]" type="file" placeholder="Ваш файл">
        <br>
        <input type="submit" name="submit">
    </form>
    <?php

        echo '--------------------------------------------';
        echo '<br>';
        showThree('upload');
    ?>
</body>
</html>