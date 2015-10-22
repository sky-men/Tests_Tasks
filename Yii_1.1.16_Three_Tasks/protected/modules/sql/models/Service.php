<?php

/**
 * This is the model class for table "service".
 *
 */
class Service extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('service_group_id', 'required', 'on'=>'AddService'),
			array('service_name', 'required',),
			array('service_group_id', 'numerical', 'integerOnly'=>true),
			array('service_name', 'length', 'min'=>1, 'max'=>50),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
