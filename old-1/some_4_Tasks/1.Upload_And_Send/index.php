<?php

require_once __DIR__.'/config/config.php';

function upload()
{
    $extensions = array_map('trim', explode(',', EXTENSIONS));

    if (!in_array(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION), $extensions))
        return 'File extension is incorrect';

    if ( stripos($_FILES['image']['type'],'image') === false)
        return 'Mime type is incorrect';

    if(!is_writable(UPLOAD_DIR) or !is_dir(UPLOAD_DIR))
        return "Directory '".UPLOAD_DIR."' doesn't exist or not writable";

    if(!is_uploaded_file($_FILES['image']['tmp_name']))
        return 'This file is not loaded';

    $file = UPLOAD_DIR.'/'.pathinfo($_FILES['image']['tmp_name'], PATHINFO_FILENAME ).'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $result = move_uploaded_file($_FILES['image']['tmp_name'], $file);

    if(!$result)
        return 'Impossible uploaded file';

    //cookie на 1 год. Для упрощения считаем что 1 пользователь = 1 файл
    setcookie('image', basename($file), time()+365*24*60*60, '/');

    $redirect = str_replace('{image}', basename($file), UPLOAD_REDIRECT);

    header ("Location: $redirect");

    exit;
}

if (isset($_FILES['image']))
    $err_mess = upload();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
</head>
<body>

<div style="text-align: center">

    <div style="color: red; margin-top: 10px; margin-bottom: 10px;">
        <?= @$err_mess; ?>
    </div>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="upload">
    </form>
</div>

</body>
</html>
