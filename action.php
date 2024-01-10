<?php
    require_once 'lib.php';

    session_start();

    //запрет прямого доступа к экшон
    if (empty($_SERVER['HTTP_REFERER']))  header('Location: /test/errors/403.html');

    $result ??= null;
    $fileNameArr ??= [];
    define("EXTENSIONS", $_SESSION['extensions']);
    $pathDir = $_SERVER['DOCUMENT_ROOT'] . '/test/upload/';

    $userFile = $_FILES['userFile'];
    $tmpNameArr = $userFile['tmp_name'];
    $sizeArr  = $userFile['size'];
    $nameArr = $userFile['name'];

    $uploadStatusList = [];

    if (isset($userFile)) {

        foreach ($tmpNameArr as $key => $val) {

            if (!empty(validate($key, $val,$nameArr, $sizeArr))){
                $uploadStatusList[] = [
                    'status' => 'ERROR',
                    'errors' => validate($key, $val,$nameArr, $sizeArr),
                    'name' => $nameArr[$key],
                ];
            } else {
                $uploadStatusList[] = [
                    'status' => 'SUCCESS',
                    'errors' => [],
                    'name' => $nameArr[$key],
                ];
            }

            //проверка наличия директории соответственно расширению файла
            $fileExtensions = explode('.', $userFile['name'][$key]);
            $absolutPathDir = $pathDir . $fileExtensions[(count($fileExtensions) - 1)];

            if (!is_dir($absolutPathDir)) mkdir($absolutPathDir);

            if (!searchDuplicates($nameArr[$key], $absolutPathDir, $uploadStatusList)) {
                //копирование файла в директорию
                $tmpFile = $userFile['tmp_name'][$key];
                $newNameFile = $userFile['name'][$key];
                $fileNameArr[] = $newNameFile;
                if (copy($tmpFile, ($absolutPathDir . '/' . $newNameFile))) {
                    $result .= $newNameFile . '<br>';
                }
            }
        }
    }
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
    echo $result;
    echo '<br>';
    echo '<br>';

    echo '</pre>';
    echo '-----------------------';
    echo '<br>';
    echo "Logs:";
    echo '<br>';
    echo '<pre>';
    print_r($uploadStatusList);
?>
</body>
</html>
<?php

