<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $db = Yii::app()->db;

        $dates = SqlModuleUtils::createDatesBasedBilling();

        if (!$dates) {
            $this->render('index');
            return true;
        }

        $and = SqlModuleUtils::getAndForQuery();


        $data = $db->createCommand("SELECT
                                              service_name,
                                              sum(billing.amount) AS sum,
                                              service_group.service_group_name
                                          FROM service
                                              LEFT JOIN service_group ON service_group.service_group_id = service.service_group_id
                                              LEFT JOIN billing ON billing.service_id = service.service_id $and
                                          GROUP BY service.service_id")
            ->queryAll();

        $this->render('index', array(
            'dates' => $dates,
            'data' => $data,
            'services' => Service::model()->findAll(),
        ));

        return true;
    }

    public function actionImport()
    {
        $files[] = '/../data/service_group.txt';
        $files[] = '/../data/service.txt';
        $files[] = '/../data/billing.txt';

        foreach ($files as $file) {

            $file = str_replace('\\', '/', realpath(__DIR__ . $file));

            $tbl = pathinfo($file, PATHINFO_FILENAME);

            Yii::app()->db->createCommand("LOAD DATA INFILE '$file' REPLACE INTO TABLE $tbl IGNORE 1 LINES;")->execute();
        }

        Yii::app()->user->setState('message', 'Success');

        $this->redirect($this->createUrl('/sql/'));
    }

    public function actionAddService()
    {
        $model = new Service();

        $model->setScenario('AddService');

        $_POST = Utils::additionalSecurity($_POST);

        $model->attributes = $_POST;

        if ($model->validate()) {

            $model->save();

            Yii::app()->user->setState('message', 'Success');
        } else
            Yii::app()->user->setState('errors', $model->getErrors());

        $this->redirect($this->createUrl('/sql/'));
    }

    public function actionUpdateService()
    {
        $model = new Service();

        $_POST = Utils::additionalSecurity($_POST);

        $model->attributes = $_POST;

        if ($model->validate())
            $model->updateByPk($_POST['service_id'], array('service_name' => $_POST['service_name']));

        return true;
    }
}