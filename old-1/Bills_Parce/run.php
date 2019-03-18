<?php

require_once 'functions.php';

$pregs['table'] = '~<table.+?id="bizon_api_news_list".+?>([\s\S]+?)</table>~im'; //главная таблица
$pregs['rows'] = '~<tr.+?class="bizon_api_news_row">([\s\S]+?)</tr>~im'; //ряды с данными из главной таблицы
$pregs['data'] = '~<td.*?>([\s\S]+?)</td>~im'; //конкретные данные
$pregs['link'] = '~<a.+?href="(.+?)".*?>(.+?)</a>~im'; //ссылка

$content = curl('http://www.bills.ru');

//$content = file_get_contents('page.html'); //если дизайн на bills.ru поменяется, - в page.html старый дизайн

//выбираем главную html-таблицу с данными
preg_match($pregs['table'], $content, $matches);

//выбираем колонки из этой таблицы
preg_match_all($pregs['rows'], $matches[0], $matches);

//из этих колонок формируем конкретные данные (date, title, url) для последующей вставки в sql
foreach ($matches[0] as $key=>$match){

    //выборка даты и <a>-ссылки
    preg_match_all($pregs['data'], $match, $data);

    //конвертация даты для MySQL
    $results[$key]['date'] = date_convert(strip_tags($data[1][0]));

    //получение url и заголовка из <a>-ссылки
    preg_match($pregs['link'], $data[1][1], $link);

    $results[$key]['url'] = $link[1];

    $results[$key]['title'] = $link[2];
}

//создание запроса для MySQL
$query = createQuery($results);

$result = mySQLconnect()->query($query);

if(!$result)
    exit ($mysqli->error);
else
    echo 'Success';