<?php

class Model
{
    protected $mysqli = null;

    public function __construct()
    {
        if(!$this->mysqli)
        {
            $config = require APPLICATION_PATH.'/configs/config.php';
            
            $this->mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['db_name']);

            if (mysqli_connect_errno())
                throw new Exception('Connect error. '. mysqli_connect_error());
        }
    }

    public function insert($query)
    {
        $result = $this->mysqli->query($query);

        $this->error($result);

        return $this->mysqli->insert_id;
    }

    public function query($query)
    {
        $result = $this->mysqli->query($query);

        $this->error($result);

        return $result;
    }

    protected function error($result)
    {
        if(!$result)
            throw new Exception('MySQL error. '.$this->mysqli->error);

        return true;
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }

    /**
     * Замена стандартному методу fetch_all в mysqli, т.к. он доступен только если установлен MySQL Native Driver (mysqlnd)
     *
     * @param mysqli_result $result
     * @return array
     */
    public function mysqliFetchAll(mysqli_result $result)
    {
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $rows[] = $row;

        return $rows;
    }
}