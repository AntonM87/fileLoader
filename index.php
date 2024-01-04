<?php
require_once "lib.php";
session_start();

$extensions = $_SESSION['extensions'] = ['pdf', 'torrent', 'jpg'];

//установка источника для индекса
$_SESSION['origin'] = 'index';
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
    foreach ($extensions as $v){
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