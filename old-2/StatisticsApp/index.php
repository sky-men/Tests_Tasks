<?php

use includes\classes\Controller;

require_once 'includes/autoloader.php';

$_POST['data'] = file_get_contents('includes/data/received_data.json');

$action = isset($_GET['action']) ?? '';

if ($action == 'insert')
    $result = Controller::insertData();
else
    $result = Controller::getData();


echo $result;