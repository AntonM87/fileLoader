<?php
//Вывод каталогов и файлов после формы
function showThree($dir) : void
{
    $files = array_diff(scandir($dir), ['..', '.']);
    foreach ($files as $file)
    {
        $path = $dir . '/' . $file;

        if (is_dir($path)){
            showThree($path);
        } else {
            $arr = explode('/',$path);
            unset($arr[0]);
            $finalPath = implode('\\',$arr);
            echo "$finalPath <br>";
        }
    }
}

//загружен ли файл?
function isUpload($file) : void
{
        if (!is_uploaded_file($file)) exit("Upload file error - $file");
}

//проверка размера файла
 function sizeValidation(int $fileSize, int $limit) : void
 {
     if ($fileSize > ($limit * 1024 * 1024)) {
         exit('File is bigger 5Mb');
     }
 }
//Проверка разширения файла
function extensionValidation (string $fullFileName, array $extensionArr) : void
{
    $explodeStrArr = explode('.',$fullFileName);
    $extension = $explodeStrArr[count($explodeStrArr)-1];
    if (!in_array($extension,$extensionArr)) exit('This extension is not allowed');
}

//проверка наличия директории соответственно расширению файла или ее создание
function searchingAndCreatingDirectory(string $dir) : void
{
    $fileExtensions = explode('.',$dir);
    $pathDir = $_SERVER['DOCUMENT_ROOT'] .'/test/upload/';
    $absolutPathDir = $pathDir . $fileExtensions[(count($fileExtensions)-1)];
    if (!is_dir($absolutPathDir)) mkdir($absolutPathDir);
}
//Поиск дубликатов
function searchDuplicates(string $nameFile, string $pathDir, array &$errors) : bool
{
    $files = scandir($pathDir);
    foreach ($files as $file){
        if ($file == $nameFile){
            $errors[] = "<strong>File already exists</strong> - $file";
            return true;
        }
    }
    return false;
}