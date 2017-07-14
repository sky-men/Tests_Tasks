<?php

class DefaultController extends Controller
{
    protected $model;

    protected $upload_dir;

    public function init()
    {
        parent::init();

        if (Yii::app()->user->getIsGuest())
            $this->redirect($this->createUrl('/site/login'));

        $this->model = new UploadForm;

        $this->upload_dir = YiiBase::getPathOfAlias('application') . Yii::app()->params['upload_dir'];
    }

    public function actionIndex()
    {
        $this->render('index', array(
            'model' => $this->model,
            'files' => scandir($this->upload_dir),
        ));
    }

    public function actionUpload()
    {
        if (!empty($_POST) and $this->model->validate()) {

            $this->model->user_file = CUploadedFile::getInstance($this->model, 'user_file');

            //сохраняем с оригинальным именем
            $this->model->user_file->saveAs($this->upload_dir . '/' . $this->model->user_file->name);

            Yii::app()->user->setState('message', 'Success');
        } else
            Yii::app()->user->setState('errors', $this->model->getErrors());

        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionRead($file)
    {
        $file_content = null;

        $file = $this->upload_dir . '/' . basename($file);

        if (file_exists($file) and is_file($file))
            $file_content = file_get_contents($file);

        $this->render('index', array(
            'model' => $this->model,
            'files' => scandir($this->upload_dir),
            'file_content' => $file_content,
        ));
    }

    public function actionDelete($file)
    {
        $file = $this->upload_dir . '/' . basename($file);

        if (file_exists($file) and is_file($file))
            unlink($file);

        Yii::app()->user->setState('message', 'Success');

        $this->redirect($this->createUrl('/cms'));
    }
}