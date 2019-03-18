<?php

namespace includes\classes;

class Config
{
    protected static $config = null;

    private final function __construct(){}

    public static function getConfig(string $section = null)
    {
        if (!self::$config)
            self::$config = require 'main.php';

        if ($section)
            return self::$config[$section];
        else
            return self::$config;
    }
}