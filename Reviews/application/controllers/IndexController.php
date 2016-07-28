<?php

class IndexController extends Controller
{
    public function indexAction()
    {
        require_once APPLICATION_PATH.'/models/ReviewsModel.php';

        parent::__construct(new ReviewsModel, $this->view);

        if (isset($_SESSION['admin']))
            $reviews = $this->model->getReviews();
        else
            $reviews = $this->model->getReviews('accepted = 1');

        $content = $this->view->render(array('reviews'=>$reviews));

        return $content;
    }
}