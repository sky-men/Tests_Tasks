<?php

defined('CLASS_PATH') or define('CLASS_PATH', __DIR__.DIRECTORY_SEPARATOR."Classes");

//so far, hardcoded some include_path, so that simplify including .php files in that case
set_include_path(implode(PATH_SEPARATOR, array(
    CLASS_PATH.'/Product',
    CLASS_PATH.'/Payment/Method',
    get_include_path()
)));

spl_autoload_register(function ($class) {
    $class = ucfirst($class);

    $path = __DIR__ . "/Classes/$class/$class.php";

    if (file_exists($path))
        require $path;
    else
        require "$class.php";
});