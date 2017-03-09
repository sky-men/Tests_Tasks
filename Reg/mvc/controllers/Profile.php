<?php

Class ProfileController extends Controller
{
    protected $owner = false;

    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION['user']) and !isset($_GET['id']))
            Utils::redirect('/');

        if(isset($_SESSION['user']))
        {
            if(isset($_GET['id']) and $_GET['id'] == $_SESSION['user']['id'])
                $this->owner = true;
            elseif(!isset($_GET['id']))
                $this->owner = true;
        }
    }
    
    public function indexAction()
    {
        if(isset($_GET['id']) and is_numeric($_GET['id']))
            $user_id = $_GET['id'];
        else
            $user_id = $_SESSION['user']['id'];

        $this->view->owner = $this->owner;

        $this->view->user = $this->model->getProfile($user_id);

        $this->view->logs = $this->model->query("SELECT * FROM logs_auth WHERE user_id = '$user_id' ORDER BY date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
    }

    public function updateAction()
    {
        if(!$this->owner)
            Utils::redirect($_SERVER[HTTP_REFERER], ['type'=>'error_mess', 'text'=>'Обновлено не удалось']);

        $data['name'] = $_POST['name'];
        $data['address'] = $_POST['address'];
        $data['tel'] = $_POST['tel'];

        $this->model->update($data, "id={$_SESSION['user']['id']}");

        $_SESSION['user'] = $this->model->getProfile($_SESSION['user']['id']);

        Utils::redirect('/profile/', ['type'=>'success_mess', 'text'=>'Обновлено успешно']);
    }
}