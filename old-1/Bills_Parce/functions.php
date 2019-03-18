<?php

/**
 * Подключение к MySQL
 * 
 * @return mysqli
 */
function mySQLconnect()
{
    global $mysqli;

    $mysqli = new mysqli('localhost', 'some_db_user', 'some_db_pass', 'some_db_name');

    if (mysqli_connect_errno())
         exit(mysqli_connect_error());

    return $mysqli;
}

/**
 * Создание запроса для MySQL по необходимым данным
 *
 * @param array $results двумерный массив с date, title, url
 * @return string готовый MySQL запрос
 */
function createQuery(array $results)
{
    $query = 'REPLACE INTO bills_ru_events (date, title, url) VALUES ';

    $values = '';

    foreach ($results as $result){
        $result['title'] = iconv('WINDOWS-1251', 'UTF-8', $result['title']);

        $result['title'] = addslashes($result['title']);

        $values .= "('$result[date]', '$result[title]', '$result[url]'),";
    }

    $values = trim($values,',');

    $query .= $values;

    return $query;
}

/**
 * Небольшая обвертка для curl, для получения интернет-страницы
 *
 * @param string $link url-страницы
 * @return string возвращает html-контент страницы
 */
function curl($link)
{
    $curl = curl_init($link);

    if (substr($link, 0, 5) == "https") {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 7);
    curl_setopt($curl, CURLOPT_TIMEOUT, 7);
    $content = curl_exec($curl);
    curl_close($curl);

    return $content;
}

/**
 * Конвертация даты из формата отображенного на html-странице в MySQL-формат
 *
 * @param $str
 * @return string
 */
function date_convert($str)
{
    $str = iconv('WINDOWS-1251', 'UTF-8', $str);

    if (mb_stripos($str,'янв'))
        $month = 1;
    elseif (mb_stripos($str,'фев'))
        $month = 2;
    elseif (mb_stripos($str,'мар'))
        $month = 3;
    elseif (mb_stripos($str,'апр'))
        $month = 4;
    elseif (mb_stripos($str,'май'))
        $month = 5;
    elseif (mb_stripos($str,'июн'))
        $month = 6;
    elseif (mb_stripos($str,'июл'))
        $month = 7;
    elseif (mb_stripos($str,'авг'))
        $month = 8;
    elseif (mb_stripos($str,'сен'))
        $month = 9;
    elseif (mb_stripos($str,'окт'))
        $month = 10;
    elseif (mb_stripos($str,'ноя'))
        $month = 11;
    elseif (mb_stripos($str,'дек'))
        $month = 12;

    $day = intval($str);

    $date = date('Y')."-$month-$day 00:00:00";

    return $date;
}