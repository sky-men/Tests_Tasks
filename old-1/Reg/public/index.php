<?php

define('APP', realpath(__DIR__ . '/../'));

set_include_path(APP . '/core/');

require_once 'Core.php';

Core::Run();