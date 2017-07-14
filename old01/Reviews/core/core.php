<?php

/**
 * Class Core класс простейшего ядра приложения
 */
class Core
{
    public static function run()
    {
        require_once 'route.php';
        require_once 'mvc.php';

        require_once 'model.php';
        require_once 'controller.php';
        require_once 'view.php';
        require_once 'layout.php';

        self::initPatchConsts();

        require_once APPLICATION_PATH.'/Bootstrap.php';

        self::registerAutoloaders();

        $route = Route::getRoute();

        Bootstrap::init();

        MVC::run($route);
    }

    public static function registerAutoloaders()
    {
        set_include_path(
            implode(PATH_SEPARATOR,
                array(VENDORS_PATH,
                    LIBRARIES_PATH,
                    get_include_path())));

        spl_autoload_register(function ($class) {
            $class = str_replace('_', '/', $class);

            $class = VENDORS_PATH . '/' . $class . '.php';

            if(file_exists($class))
                require_once $class;
        });
    }

    public static function initPatchConsts()
    {
        define('ROOT_PATH', realpath(__DIR__ . '/../'));

        define('APPLICATION_PATH', realpath(ROOT_PATH . '/application'));

        define('VENDORS_PATH', realpath(ROOT_PATH. '/vendors'));

        define('LIBRARIES_PATH', realpath(ROOT_PATH. '/libraries'));
    }
}