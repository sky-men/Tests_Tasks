<?php
require_once 'include/autoload.php';

if (!isset($argc))
    exit('Please run script from console');

if(empty($argv[1]))
    Utils::ShowError('Please set shop name');

$shop = $argv[1];

$process = new Process($shop);

if($process->isRunning())
    Utils::ShowError('Previous process for this shop is still running');

$process->startWork();

$data = Parce::$shop();

Import::run($data);

Utils::ShowMessage('Success');