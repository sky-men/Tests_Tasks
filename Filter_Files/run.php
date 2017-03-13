<?php

$dir = 'datafiles';

//получить все файлы в директории
$files = scandir($dir);

//отфильтровать массив с файлами по регулярке
$files = array_filter($files, function($value){

    $preg = '~^\w+?\.ixt$~i';

    return preg_match($preg, $value);
});

echo "<pre>";
print_r ($files);
echo "</pre>";

//P.S. Если файлов в директории может быть много, то можно сделать аналог scandir сразу с фильтром (opendir()+readdir()+closedir())