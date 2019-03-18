<?php

Class Config
{
    private static $instance = null;

    private $config = null;

    private function __construct(){}

    public static function getConfig()
    {
        if (!self::$instance)
            self::$instance = new Config;

        if(self::$instance->config)
            return self::$instance->config;

        self::$instance->config = require_once APP.'/configs/config.php';

        return self::$instance->config;
    }

}