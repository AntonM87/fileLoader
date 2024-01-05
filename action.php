<?php
    require_once 'lib.php';

    session_start();

    //запрет прямого доступа к экшон
    $urlStr = $_SERVER['SCRIPT_NAME'];
    $scriptName = explode('/',$urlStr);
    if (($scriptName[count($scriptName)-1]) == 'action.php' && !isset($_SESSION['origin']))  header('Location: /test/errors/403.html');

    $result ??= null;
    $fileNameArr ??= [];
    $errors ??= [];
    $extensions = $_SESSION['extensions'];
    $pathDir = $_SERVER['DOCUMENT_ROOT'] . '/test/upload/';

    $tmpNameArr = $_FILES['userFile']['tmp_name'];
    $sizeArr  = $_FILES['userFile']['size'];
    $nameArr = $_FILES['userFile']['name'];

    if (isset($_FILES['userFile'])) {

        foreach ($tmpNameArr as $key => $val) {
            isFileAlreadyUploaded($val, $errors); //загружен ли файл?
            isFileSizeValid($sizeArr[$key], 5, $errors,$nameArr[$key]); //проверка размера файла
            isFileExtensionValid($nameArr[$key], $extensions, $errors); //Проверка разширения файла

            //проверка наличия директории соответственно расширению файла
            $fileExtensions = explode('.', $_FILES['userFile']['name'][$key]);
            $absolutPathDir = $pathDir . $fileExtensions[(count($fileExtensions) - 1)];

            if (!is_dir($absolutPathDir)) mkdir($absolutPathDir);

            if (!searchDuplicates($_FILES['userFile']['name'][$key], $absolutPathDir, $errors)) {
                //копирование файла в директорию
                $tmpFile = $_FILES['userFile']['tmp_name'][$key];
                $newNameFile = $_FILES['userFile']['name'][$key];
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


    if (!empty($errors)){
        echo '-----------------------';

        echo '<br>';
        echo "Errors:";
        echo '<br>';
        foreach ($errors as $error) echo $error . "<br>";
    }

?>
</body>
</html>
<?php
unset($_SESSION['origin']);

