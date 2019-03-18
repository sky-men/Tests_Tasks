<?php

spl_autoload_register(function (string $class) {

    $path = realpath(__DIR__.'/../');

    $path = $path.DIRECTORY_SEPARATOR.$class.'.php';

    if(file_exists($path) and is_file($path))
        require $path;
});