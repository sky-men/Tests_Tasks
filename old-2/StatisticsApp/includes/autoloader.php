<?php

define('APP_DIR', realpath(__DIR__ . '/../'));

set_include_path(
    implode(PATH_SEPARATOR,
        [realpath(APP_DIR . '/includes/configs'),
            realpath(APP_DIR . '/includes/data'), get_include_path()]));

spl_autoload_register(function ($class) {
    $file = APP_DIR . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file) and is_file($file))
        require_once $file;
});