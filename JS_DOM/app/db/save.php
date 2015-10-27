<?php

require_once 'config.php';

if(empty($_POST['tree']))
    throw new Exception('Empty POST');

//$_POST['tree'] = addslashes($_POST['tree']);

$db->exec("INSERT OR REPLACE INTO tree (rowid, value) VALUES (1, '{$_POST['tree']}')");

echo 'OK';