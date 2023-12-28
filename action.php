<?php

echo "<pre>";
print_r($_SERVER);
echo "</pre>";

$urlStr = $_SERVER['SCRIPT_NAME'];
$scriptName = explode('/',$urlStr);

if (true) return;
else if (($scriptName[count($scriptName)-1]) == 'action.php') {
    header('Location: /test/errors/403.html');
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
<h1>Action.php</h1>
</body>
</html>