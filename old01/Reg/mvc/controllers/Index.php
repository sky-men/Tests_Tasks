<?php

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->users = $this->model->query("SELECT * FROM users ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
    }
}