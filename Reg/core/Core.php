<?php

/**
 * Class Core простой класс ядра
 */
class Core
{
    public static function Run()
    {
        session_start();

        spl_autoload_register(function ($class) {
            $file = __DIR__ . '/' . $class . '.php';

            if (file_exists($file))
                require_once $file;

            elseif (stripos($class, 'Model')) {
                $file = substr($class, 0, strrpos($class, 'Model')) . '.php';
                $file = APP . '/mvc/models/' . $file;
                if (file_exists($file))
                    require_once $file;
            }
        });

        (new Security())->Run(["handling" => "both", "tags" => "strip", "quotes" => "strip"]);

        $route = Route::Run();

        self::MVC($route);
    }

    public static function MVC(array $route)
    {
        require_once APP . '/mvc/controllers/' . $route['controller']['file'];

        $controller = new $route['controller']['class']();

        $controller->setRoute($route);

        $action = $route['action']['method'];

        $controller->$action();

        $html = $controller->view->render($route['controller']['name'], $route['action']['name']);

        Layout::render($html);
    }
}