<?php

require_once __DIR__.'/../config/config.php';

$file = UPLOAD_DIR.'/'.$_GET['image'];

header('content-type: '.mime_content_type ($file).' ');

readfile($file);