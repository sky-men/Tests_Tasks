<?php

/**
 * Class Route простой роутинг
 *
 * @return array
 */
class Route
{
    public static function Run()
    {
        if (stripos($_SERVER['REQUEST_URI'], '?'))
            $route = explode('/', substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'?')));
        else
            $route = explode('/', $_SERVER['REQUEST_URI']);

        if(empty($route[1]))
            $route['controller']['name'] = 'index';
        else
            $route['controller']['name'] = $route[1];

        $route['controller']['name'] = strtolower($route['controller']['name']);

        $route['controller']['file'] = ucfirst($route['controller']['name']).'.php';

        $route['controller']['class'] = ucfirst($route['controller']['name'].'Controller');

        if(empty($route[2]))
            $route['action']['name'] = 'index';
        else
            $route['action']['name'] = $route[2];

        $route['action']['name'] = strtolower($route['action']['name']);

        $route['action']['method'] = $route['action']['name'].'Action';

        return $route;
    }
}