<?php

require_once '/vendor/autoload.php';

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

final class init
{
    protected $adapter;

    public function __construct()
    {
        $this->adapter = new Adapter([
            'driver' => 'Mysqli',
            'database' => 'some_db_name',
            'username' => 'some_db_login',
            'password' => 'some_db_pass']);

        $this->create();

        $this->fill();
    }

    /**
     * Создание таблицы, если не существует
     *
     * @return true
     */
    private function create()
    {
        $this->adapter->query(file_get_contents('table.sql'), Adapter::QUERY_MODE_EXECUTE);

        return true;
    }


    /**
     * Заполнить таблицу случайными данными
     *
     * @return true
     */
    private function fill()
    {
        $query = 'INSERT INTO test (script_name, start_time, end_time, result) VALUES ';

        $values = '';

        //region генерация $i строк для вставки в таблицу
        for ($i=0; $i < 10 ; $i++)
        {
            //сгенерировать случайную строку
            $script_name = function ($length = 10) {
                return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
            };

            $script_name = $script_name();

            //случайный unix timestamp от 1970г до текущего
            $start_time = rand(date_create('1970-01-01 01:00:00')->getTimestamp(), time());

            //случайный unix timestamp от $start_time до 2020г
            $end_time = rand($start_time, date_create('2020-01-01 01:00:00')->getTimestamp());

            //случайные данные для поля result
            $result = function () {
                $result = ['normal', 'illegal', 'failed', 'success'];

                shuffle($result);

                return array_pop($result);
            };

            $result = $result();

            $values .= "('$script_name', '$start_time', '$end_time', '$result'),";
        }
        //endregion

        $query .= trim($values,',');

        $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);

        return true;
    }

    /**
     * Получить необходимые данные
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function get()
    {
        $table = new TableGateway('test', $this->adapter);

        return $table->select(array('result' => ['normal', 'success']));
    }

}

$obj = new init();

$results = $obj->get();

foreach ($results as $result)
{
    echo "<pre>";
    print_r ($result);
    echo "</pre>";
}