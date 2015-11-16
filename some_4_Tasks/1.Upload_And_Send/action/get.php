<?php

require_once __DIR__.'/../config/config.php';

if (empty($_GET['image']) or !file_exists(UPLOAD_DIR.'/'.$_GET['image'])) {

    header("HTTP/1.1 404 Not Found");

    exit('Image not found');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image</title>
</head>
<body>

<div style="text-align: center">

    <div style="position: relative">

        <?php
        if(isset($_COOKIE['image']) and $_COOKIE['image'] == $_GET['image'])
            echo '<span style="font-size: 60px; top: 42%; left: 42%; position: absolute; color: white">Hello World</span>';
        ?>

        <img src="http://<?=$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/send.php?image=$_GET[image]"?>">
    </div>
</div>

</body>
</html>
