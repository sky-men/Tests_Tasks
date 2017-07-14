<?php

require_once 'config.php';

$result = $db->query('SELECT * FROM tree');

$tree = $result->fetchArray(SQLITE3_ASSOC);