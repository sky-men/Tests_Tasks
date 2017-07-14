<?php

class DefaultController extends Controller
{
	protected $model;

	protected $date_time_zone;

	public function init()
	{
		$this->model = new Purchases();

		//region Установка таймзоны
		$this->date_time_zone = new DateTimeZone('UTC');

		date_default_timezone_set($this->date_time_zone->getName());

		$this->model->getCommandBuilder()
			->createSqlCommand("SET time_zone = '".PurchasesModuleUtils::convertPHPTimeZoneToMySQL()."' ")
			->execute();
		//endregion
	}

	public function actionIndex()
	{
		//WHERE для фильтра дат
		$sql_date_where = PurchasesModuleUtils::createDateForSqlWhere();

		//region Пагинация
		$count = $this->model->getCommandBuilder()->createSqlCommand("SELECT COUNT(*) as count FROM purchases $sql_date_where")->queryRow();

		$count = intval($count['count']);
		
		$pages = new CPagination($count);

		$pages->pageSize = Yii::app()->params['pageSize'];
		//endregion

		//Выборка необходимых данных во временную таблицу для дальнейшей работы с ней
		$query = "CREATE TEMPORARY TABLE purchases_sort
				SELECT SQL_CALC_FOUND_ROWS *, (price * a_count) as sum,  FROM_UNIXTIME(ts_day_start) AS date
				FROM purchases
				$sql_date_where
				ORDER BY ts_day_start DESC
				LIMIT {$pages->offset}, {$pages->limit}
				";

		$this->model->getCommandBuilder()->createSqlCommand($query)->execute();

		//сортировка и получение данных
		$purchases = $this->model->findAllBySql('SELECT * FROM purchases_sort ORDER BY pm_id ASC, price ASC');

		//получение мин. и макс. дат в выборке
		$min_max_time = $this->model->getCommandBuilder()
			->createSqlCommand('SELECT MIN(ts_day_start) as min, MAX(ts_day_start) as max  FROM purchases_sort')
			->queryRow();


		//region интервал между мин. и мах. датой покупок, в сутках, исключая время
		$min_date = new DateTime(date ('Y-m-d',$min_max_time['min']), $this->date_time_zone);
		$min_date->setTime(0,0,0);

		$max_date = new DateTime(date ('Y-m-d',$min_max_time['max']), $this->date_time_zone);
		$max_date->setTime(0,0,0);

		$interval = date_diff($min_date,$max_date);
		unset($min_date, $max_date);
		//endregion

		//кол-во td-колонок, с датами, в html-таблице, равно кол-ву дней между минимальной и максимальной датой выборки, плюс 1
		$td_num = intval($interval->format('%a'))+1;

		$view_arr = array(
			'purchases'=>$purchases,
			'td_num'=>$td_num,
			'min_max_time'=>$min_max_time,
			'date_time_zone'=>$this->date_time_zone,
			'pages' => $pages
		);

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('index', $view_arr);
		else
			$this->render('index', $view_arr);
	}

	public function actionGenerateData()
	{
		//общее кол-во покупок (записей в БД. Равно количеству генерируемых записей за 1 sql-запрос)
		$total_purchases = 10000;

		//кол-во покупок в день
		$day_purchases = 3;

		$date = new DateTime('NOW', $this->date_time_zone);

		$this->model->getCommandBuilder()->createSqlCommand('TRUNCATE purchases;')->execute();

		$counter = 0;
		for ($z=0; $z < $total_purchases; $z += $day_purchases)
		{
			for ($i=0; $i < $day_purchases; $i++)
			{
				if($counter >= $total_purchases)
					break(2);

				//рандомное время покупок в текущих сутках
				$date->setTime(rand(0, 23),rand(0, 59), rand(0, 59));

				$array[$counter]['ts_day_start'] = $date->getTimestamp();
				$array[$counter]['pm_id'] = rand(1, 10);
				$array[$counter]['price'] = rand(100, 2000);
				$array[$counter]['a_count'] = rand(1, 10);

				$counter++;
			}

			$date->modify('-1 day');
		}

		$this->model->getCommandBuilder()->createMultipleInsertCommand($this->model->tableName(), $array)->execute();
		unset($array);

		Yii::app()->user->setState('message', 'Success');

		$this->redirect($this->createUrl('/purchases/'));
	}
}