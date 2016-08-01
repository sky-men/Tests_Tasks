<?php

if (!isset($argv['1']) or $argv['1'] != 'statistic')
{
    echo "Use php " . basename(__FILE__) . " statistic --without-documents --with-documents";
    exit;
}

echo 'Please enter start date (example 2015-07-20): ';
$dates['start'] = stream_get_line(STDIN, 1024, PHP_EOL);

echo 'Please enter end date (example 2015-07-25): ';
$dates['end'] = stream_get_line(STDIN, 1024, PHP_EOL);

$params = explode('--', implode(' ', $argv));

if (count($params) > 1)
    $params = array_map('trim', array_slice($params, 1));
else
    $params = ['with-documents', 'without-documents'];

require_once 'src/classes/Model.php';

$model = new \Apo100l\Quest\Model();

$model->init();

$statistics = $model->getStatistics($params, $dates);

if (empty($statistics))
{
    echo 'No results';
    exit;
}

foreach ($statistics as $key => $values)
    echo $key.': Count: '.$values['count'].' Amount: '.$values['amount']."\r\n";