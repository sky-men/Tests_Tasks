<?php

class Layout
{
    public static $dir = APP.'/layouts';

    public static function render($content, $layout = 'index')
    {
        require self::$dir."/$layout.php";
    }
}