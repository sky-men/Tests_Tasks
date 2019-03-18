<?php

class User
{
    private static $instance;

    private function __construct(){}

    public static function getInstanceById($id)
    {
        $class = __CLASS__;

        if(!self::$instance[$id])
            self::$instance[$id] = new $class;

        return self::$instance[$id];
    }
}