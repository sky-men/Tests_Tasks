<?php

/**
 * Class MVC простейший класс реализующий MVC
 */
Class MVC
{
    public static function run(array $route = null)
    {
        if (isset($route['controller']))
            $controller = ucfirst($route['controller']);
        else
            $controller = 'Index';

        if (isset($route['action']))
            $action = $route['action'];
        else
            $action = 'Index';

        $view = new View();

        $view->file = APPLICATION_PATH . '/views/' . lcfirst($controller) . '/' . lcfirst($action) . '.php';

        require_once APPLICATION_PATH . '/controllers/' . $controller . 'Controller.php';

        $file_model = APPLICATION_PATH . '/models/' . $controller . 'Model.php';

        $model = null;

        if (file_exists($file_model)) {
            require_once $file_model;

            $model = $controller . 'Model';

            $model = new $model;
        }

        $controller = $controller . 'Controller';

        $action = $action . 'Action';

        $controller = new $controller($model, $view);

        $content = $controller->$action();

        $layout = $controller->getLayout();

        if ($layout and $layout->file)
            $layout->render(array('content' => $content));
        else
            echo $content;
    }
}