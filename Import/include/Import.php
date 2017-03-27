<?php

/**
 * Class Import класс для работы с БД
 */
Class Import
{
    protected static $mysqli = null;

    /**
     * Подключение к БД
     */
    public static function connect()
    {
        if(!self::$mysqli)
        {
            self::$mysqli = new mysqli('localhost', 'some_user', 'some_password', 'some_db_name');

            if (mysqli_connect_errno())
                Utils::ShowError('Connect error. '. mysqli_connect_error());
        }
    }

    /**
     * Импортирование в БД отпарсеных ранее данных
     *
     * @param array $data отпарсеные данные
     * @return bool
     */
    public static function run(array $data)
    {
        self::connect();

        $query = 'INSERT IGNORE INTO orders (shop_id, order_id, status, sum, currency, date) VALUES';

        $to_query = '';

        $i = 0; //счетчик достижения лимита в INSERT

        $z = 0; //общий счетчик проходов цикла

        $size = count($data);

        foreach ($data as $values)
        {
            $z++;

            $i++;

            $to_query .= "($values[shop_id], $values[order_id], '$values[status]', '$values[sum]', '$values[currency]', '$values[date]'),";

            /**
             * В $i сколько строчек insert-ить за 1 запрос к БД.
             *
             * Если не достигнул лимит по insert-ам, и не конец данных, то продолжаем набор в sql-запрос. Иначе insert-им то что есть
             */
            if($i != 10000 and $z != $size)
                continue;

            $to_query = trim($to_query,',');

            $fin_query = $query.$to_query;
            
            $result = self::$mysqli->query($fin_query);

            if(!$result)
                Utils::ShowError('MySQL error. '.self::$mysqli->error);

            $i = 0;
            $to_query = '';
        }

        return true;
    }
}