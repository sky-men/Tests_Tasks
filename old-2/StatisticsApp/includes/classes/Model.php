<?php

namespace includes\classes;

class Model
{
    /* @var $db \mysqli */
    protected static $db = null;

    public function __construct()
    {
        if (!self::$db)
            $this->setDb();
    }

    protected function setDb(): void
    {
        if (!self::$db) {
            $config = Config::getConfig('db');

            self::$db = new \mysqli($config['host'], $config['user'], $config['password'], $config['dbname']);
        }
    }

    public function insertData(array $data): bool
    {
        $result = self::$db->query("UPDATE statistics SET counter = counter + 1 
                                            WHERE date = CURDATE() AND country = '$data[country]' AND event = '$data[event]'");

        if (!self::$db->affected_rows)
            $result = self::$db->query("INSERT INTO statistics SET date = CURDATE(), country = '$data[country]', event = '$data[event]', counter = 1");

        return $result;
    }

    public function getData(): ?array
    {
        $countries = Config::getConfig('top_countries');

        $in = '';
        foreach ($countries as $country)
            $in .= "'$country', ";

        $in = trim($in, ', ');

        $result = self::$db->query("SELECT date, country, event, SUM(counter) AS sum 
                                              FROM `statistics` 
                                          WHERE country IN($in) and TO_DAYS(NOW()) - TO_DAYS(date) <= 7
                                              GROUP BY event");

        return $result->fetch_all(MYSQLI_ASSOC) ?? null;
    }


}