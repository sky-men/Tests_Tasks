<?php


class ReviewsController extends Controller
{
    public function sendAction()
    {
        if(isset($_POST['update']))
            $this->checkAccess();

        $this->validateReview();

        $this->mysqli->begin_transaction();

        if(isset($_POST['update']))
        {
            $review_id = (int)$_POST['update'];

            $arr = $_POST;

            unset($arr['update']);

            $this->model->updateReview($arr, $review_id);
        }
        else
            $review_id = $this->model->sendReview($_POST);

        if (!empty($_FILES['image']['name']))
            $this->upload($review_id);

        $this->mysqli->commit();

        if(!isset($_POST['update']))
            $_SESSION['success_mess'] = 'Добавлено успешно. Отзыв появится после проверки администратором';
        else
            $_SESSION['success_mess'] = 'Обновлено успешно';

        $this->redirect();
    }

    protected function validateReview()
    {
        $validator = new Zend_Validate();

        $validator->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 50, 'encoding' => 'UTF-8')));

        $this->validate($validator, array($_POST['name'], $_POST['email']));

        $validator->addValidator(new Zend_Validate_EmailAddress());

        $this->validate($validator, $_POST['email']);

        $validator = new Zend_Validate();

        $validator->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 1000, 'encoding' => 'UTF-8')));

        $this->validate($validator, $_POST['review']);
    }

    protected function upload($review_id)
    {
        require_once 'Images/Utils.php';

        $config = require APPLICATION_PATH . '/configs/config.php';

        $upload_dir = PUBLIC_PATH . '/' . $config['upload_dir'];

        if (!file_exists($upload_dir) or !is_dir($upload_dir) or !is_writable($upload_dir))
            throw new Exception ("Директория $upload_dir не существует, или недоступна для записи");

        $ext = substr($_FILES['image']['name'],strrpos($_FILES['image']['name'],'.')+1);

        $ext = strtolower($ext);

        if(empty($ext) or ($ext !== 'jpg' and $ext !== 'gif' and $ext !== 'png'))
            throw new Exception ("Только файлы форматов JPG, GIF, PNG");

        if(isset($_POST['update']))
        {
            $review = $this->model->getReviews("id = $review_id");

            if(!empty($review[0]['image']))
            {
                $image = $upload_dir.$review[0]['image'];
                
                unlink($image);

                unset($image);
            }
        }

        $result = Images\Utils::uploadImage('image', $upload_dir, array('width' => 320, 'height' => 240));

        $this->model->updateReview(array('image' => basename($result['file'])), $review_id);

        return true;
    }
}