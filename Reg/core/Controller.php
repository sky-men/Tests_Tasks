<?php

Class Controller
{
    public $view;

    private $model = null;

    protected $route;

    public function __construct()
    {
        $this->view = new View();
    }

    public function __get($name)
    {
        if ($name == 'model') {
            if ($this->model)
                return $this->model;

            if (isset($this->route['controller']['file']) and file_exists(APP . "/mvc/models/{$this->route['controller']['file']}"))
                $model_name = ucfirst($this->route['controller']['name'] . 'Model');
            else
                $model_name = 'Model';

            $this->model = new $model_name();

            return $this->model;
        }
    }

    public function setRoute(array $route)
    {
        $this->route = $route;
    }
}