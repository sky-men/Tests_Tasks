<?php

$db_file = __DIR__.'/db/sqlite.db';

$db = new SQLite3($db_file);

$db->exec('CREATE TABLE IF NOT EXISTS tree (value TEXT)');