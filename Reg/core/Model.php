<?php

Class Model
{
    public $table = null;

    protected $mysqli;

    public function __construct()
    {
        $config = Config::getConfig();

        $this->mysqli = new mysqli($config['db']['host'], $config['db']['login'], $config['db']['password'], $config['db']['name']);

        if (mysqli_connect_errno())
            throw new Exception(mysqli_connect_error());
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }

    public function query($query)
    {
        $result = $this->mysqli->query($query);

        if(!$result)
            throw new Exception($this->mysqli->error);

        return $result;
    }

    public function insert(array $data)
    {
        $set = $this->createSetForQuery($data);

        $query = "INSERT INTO $this->table SET $set";

        return $this->query($query);
    }

    public function update(array $data, $where)
    {
        $set = $this->createSetForQuery($data);

        $query = "UPDATE $this->table SET $set WHERE $where";

        return $this->query($query);
    }

    private function createSetForQuery(array $data)
    {
        $set = '';

        foreach ($data as $key=>$values)
            $set .= "$key = '$values', ";

        $set = trim($set, ', ');

        return $set;
    }


}