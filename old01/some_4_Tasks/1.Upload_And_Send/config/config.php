<?php

define('UPLOAD_DIR',  realpath(__DIR__.'/../upload'));

define('UPLOAD_REDIRECT',  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'upload/{image}');

define('EXTENSIONS',  'jpg, png');