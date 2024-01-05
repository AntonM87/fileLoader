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
function isFileAlreadyUploaded($file) : bool
{
        if (is_uploaded_file($file)) {
            return true;
        }
        return false;
}

//проверка размера файла
 function isFileSizeValid(int $fileSize, int $limit) : bool
 {
     if ($fileSize < ($limit * 1024 * 1024)) {
         return true;
     }
     return false;
 }

//Проверка разширения файла
function isFileExtensionValid (string $fullFileName, array $extensions) : bool
{
    $explodeStrArr = explode('.',$fullFileName);
    $extension = $explodeStrArr[count($explodeStrArr)-1];

    if (in_array($extension,$extensions)){
        return true;
    }
    return false;
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
function searchDuplicates(string $nameFile, string $pathDir, array &$uploadStatusList) : bool
{
    $files = scandir($pathDir);
    foreach ($files as $file){
        if ($file == $nameFile){
            $uploadStatusList[] = [
                'status' => 'ERROR',
                'errors' => "File already exists",
                'name' => $file,
            ];
            return true;
        }
    }
    return false;
}
function validate($key, $val, $nameArr, $sizeArr) : array
{
    $result ??= [];

    if (!isFileAlreadyUploaded($val)) $result[] = "Upload file error";

    if (!isFileSizeValid($sizeArr[$key], 5)) $result[] = "File is bigger 5Mb";

    if (!isFileExtensionValid($nameArr[$key], EXTENSIONS)) $result[] = "Invalid extension";

    return $result;
}