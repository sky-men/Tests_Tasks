<?php

class AdminController extends Controller
{
    public function indexAction()
    {
        if(isset($_SESSION['admin']))
            $this->redirect();

        $content = $this->view->render();

        return $content;
    }

    public function authAction()
    {
        if (isset($_POST['user']) and isset($_POST['password']) and $_POST['user'] == 'admin' and $_POST['password'] == 123)
        {
            $_SESSION['admin'] = 1;

            $_SESSION['success_mess'] = 'Авторизация успешна';

            $this->redirect();
        }
        else
        {
            $_SESSION['error_mess'] = 'Некорректный логин или пароль';

            $this->redirect('/admin/');
        }
    }

    public function updateAction()
    {
        $this->checkAccess();

        require_once APPLICATION_PATH.'/models/ReviewsModel.php';

        parent::__construct(new ReviewsModel, $this->view);

        $review_id = (int)$_GET['review_id'];

        $review = $this->model->getReviews("id = $review_id");

        if(isset($review[0]))
            $review = $review[0];

        $content = $this->view->render(array('review'=>$review));

        return $content;
    }

    public function acceptAction()
    {
        $this->checkAccess();

        $review_id = $this->initForModeration();

        $this->model->setAccepted($review_id);

        $_SESSION['success_mess'] = 'Одобрено';

        $this->redirect();
    }

    public function rejectAction()
    {
        $this->checkAccess();

        $review_id = $this->initForModeration();

        $this->model->setRejected($review_id);

        $_SESSION['success_mess'] = 'Отклонено';

        $this->redirect();
    }

    public function onModerationAction()
    {
        $this->checkAccess();

        $review_id = $this->initForModeration();

        $this->model->setOnModeration($review_id);

        $_SESSION['success_mess'] = 'На модерации';

        $this->redirect();
    }

    protected function initForModeration()
    {
        require_once APPLICATION_PATH.'/models/ReviewsStatusModel.php';

        parent::__construct(new ReviewsStatusModel, $this->view);

        $review_id = (int)$_GET['review_id'];

        return $review_id;
    }
}