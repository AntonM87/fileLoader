<?php
    require_once 'lib.php';

    session_start();

    //запрет прямого доступа
    $urlStr = $_SERVER['SCRIPT_NAME'];
    $scriptName = explode('/',$urlStr);
    if (($scriptName[count($scriptName)-1]) == 'action.php' && !isset($_SESSION['origin']))  header('Location: /test/errors/403.html');

    $fileNameArr = $_SESSION['fileNameArr'];
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
    <strong><h2>Загружены данные файлы:</h2></strong>
    <br>
<?php
    foreach ($fileNameArr as $file){
        echo $file . '<br>';
    }
?>
</body>
</html>
<?php
unset($_SESSION['origin']);
//unset($_SESSION['fileNameArr']);

echo '<pre>';
print_r($_SESSION);
echo '<pre>';