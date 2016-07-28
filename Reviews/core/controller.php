<?php

class Controller
{
    protected $model;

    protected $mysqli = null;

    protected $view;

    protected $layout = null;

    protected $config = null;

    public function __construct(Model $model = null, View $view)
    {
        $this->model = $model;

        if($this->model)
            $this->mysqli = $this->model->getMysqli();

        $this->view = $view;

        if(!$this->config)
            $this->config = require APPLICATION_PATH.'/configs/config.php';

        if(!$this->layout)
        {
            $this->layout = new Layout();

            if(isset($this->config['layout']) and !empty($this->config['layout']))
                $this->layout->file = APPLICATION_PATH.'/layouts/'.$this->config['layout'].'.php';
        }
    }

    public function getLayout()
    {
        return $this->layout;
    }

    protected function checkAccess()
    {
        if(!isset($_SESSION['admin']))
        {
            $_SESSION['error_mess'] = 'У Вас нет доступа к запрашиваемой странице';

            $this->redirect();
        }

        return true;
    }

    public function validate(Zend_Validate $validator, $what, $redirect = '/')
    {
        if(is_array($what))
        {
            foreach ($what as $values)
                $this->validate($validator, $values, $redirect);

            return true;
        }

        if (!$validator->isValid($what))
        {
            $_SESSION['error_mess'] = @array_pop($validator->getMessages());

            $this->redirect();
        }

        return true;
    }

    public function redirect($where = '/')
    {
        header("Location: $where");

        exit;
    }
}