<?php

$dir = 'datafiles';

//�������� ��� ����� � ����������
$files = scandir($dir);

//������������� ������ � ������� �� ���������
$files = array_filter($files, function($value){

    $preg = '~^\w+?\.ixt$~i';

    return preg_match($preg, $value);
});

echo "<pre>";
print_r ($files);
echo "</pre>";

//P.S. ���� ������ � ���������� ����� ���� �����, �� ����� ������� ������ scandir ����� � �������� (opendir()+readdir()+closedir())