<?php
require_once 'app/autoloader.php';

use app\parsers\EmptyParser;

$parser = new EmptyParser();

$parser->run();