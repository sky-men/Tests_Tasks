<?php

/**
 * Class Route класс простейшего роутинга
 */
class Route
{
    public static function getRoute()
    {
        if (strpos($_SERVER['REQUEST_URI'], '?'))
            $array = explode('/', substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')));
        else
            $array = explode('/', $_SERVER['REQUEST_URI']);

        $route = null;

        if (!empty($array[1]))
            $route['controller'] = $array[1];

        if (!empty($array[2]))
            $route['action'] = $array[2];

        return $route;
    }
}