<?php

/**
 * This is the model class for table "service".
 *
 */
class Purchases extends CActiveRecord
{
    public $sum;

    public $date;

    public function getDbConnection()
    {
        $conection = Yii::app()->db_purchases;

        $conection->setActive(true);

        return $conection;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchases';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array();
    }


    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
