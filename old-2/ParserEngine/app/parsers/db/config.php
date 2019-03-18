<?php

/**
 * Подключение и инициализация ORM от Yii2 (ActiveRecord)
 *
 * Необходимо скачать Yii2 в корень проекта например командой:
 *   - composer require cebe/assetfree-yii2
 *
 * И создать таблицу в БД командой из файла table.sql
 */


$vendor_path = __DIR__ . '/../../../vendor/';

require $vendor_path.'autoload.php';

require $vendor_path. 'yiisoft/yii2/Yii.php';

$yiiConfig = [
    'id' => 'basic-console',
    'basePath' => realpath($vendor_path.'../'),
    'components' => [
        //параметры подключения к базе данных
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=my_db_name',
            'username' => 'some_user',
            'password' => 'some_password',
            'charset' => 'utf8',
        ],
    ],
];


new \yii\console\Application($yiiConfig);

require_once __DIR__.'/Model.php';
