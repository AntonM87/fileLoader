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
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input multiple name="userFile[]" type="file" placeholder="Ваш файл">
        <br>
        <input type="submit" name="submit">
    </form>
</body>
</html>
<?php

echo $_SERVER['DOCUMENT_ROOT'];

//загружен ли файл
foreach ($_FILES['userFile']['tmp_name'] as $value) {
    if (!is_uploaded_file($value)) {
        exit('Upload file error');
    }
}

//проверка размера файла
foreach ($_FILES['userFile']['size'] as $value) {
    if ($value > (5 * 1024 * 1024)) {
        exit('File is bigger 5Mb');
    }
}

//проверка наличия директории соответственно расширению файла
foreach ($_FILES['userFile']['name'] as $key => $value){
    $fileExtensions = explode('.',$value);
    $pathDir = $_SERVER['DOCUMENT_ROOT'] .'/test/upload/';
    $absolutPath = $pathDir . $fileExtensions[(count($fileExtensions)-1)];
    if (!is_dir($absolutPath)) mkdir($absolutPath);

//копирование файла в директорию
    $tmpFile = $_FILES['userFile']['tmp_name'][$key];
    $newNameFile = $_FILES['userFile']['name'][$key];
    copy($tmpFile, $newNameFile);
    move_uploaded_file($newNameFile,$absolutPath  . '/');
}
echo "<pre>";
print_r($_FILES);
echo "</pre>";