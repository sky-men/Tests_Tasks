<?php

Class AuthController extends Controller
{
    public function registerAction()
    {
        $model = new ProfileModel();

        $model->isValid();

        $_POST['password'] = md5($_POST['password']);

        $_POST['confirm_hash'] = Utils::getRandomString();

        $model->insert($_POST);

        Utils::mail(
            $_POST['email'],
            'no-reply@mail.com',
            'Confirm email',
            "Go to link: ".'http://'. $_SERVER['SERVER_NAME'].'/auth/confirm/?email='.$_POST['email'].'&hash='.$_POST['confirm_hash']
            );

        Utils::redirect('/', ['type'=>'success_mess', 'text'=>'Регистрация успешна. Подтвердите email. Авторизация уже возможна']);
    }

    public function confirmAction()
    {
        $query = "SELECT * FROM users WHERE email = '$_GET[email]' and confirm_hash = '$_GET[hash]' LIMIT 1";

        $result = $this->model->query($query);

        $row = $result->fetch_array(MYSQLI_ASSOC);

        $this->model->table = 'users';

        if($row)
            $this->model->update(['confirm_hash'=>null], "id=$row[id]");

        Utils::redirect('/', ['type'=>'success_mess', 'text'=>'Email подтвержден']);
    }

    public function loginAction()
    {
        $model = new AuthModel();

        $_POST['password'] = md5($_POST['password']);

        $result = $model->checkLogin();
        
        if($result)
        {
            $model->table = 'logs_auth';
            
            $model->insert([
                'user_id'=>$result['id'],
                'date'=>date('Y-m-d H:i:s'),
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'browser'=>$_SERVER['HTTP_USER_AGENT']
            ]);

            $_SESSION['user'] = $result;

            Utils::redirect('/profile/');
        }
        else
            Utils::redirect('/', ['type'=>'error_mess', 'text'=>'Некорректная авторизация']);
    }

    public function logoutAction()
    {
        unset($_SESSION['user']);

        session_destroy();

        Utils::redirect('/');
    }
}