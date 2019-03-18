<!--
Задание:

    Есть одномерный массив (размер произвольный) чисел больше 0.

    Задача вывести все его элементы в 7 колонок, в таблице с border="1".

    У пустых ячеек должна быть рамка
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Массив в колонки</title>

    <style>
        table {
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }

        table td {
            padding: 5px;
            text-align: center;
        }
    </style>

</head>
<body>


<table border="1">

    <?php

    //кол-во колонок, в которые надо вывести значение массива
    $num_columns = 7;

    $array = range(1, 100);

    $i = 1;

    foreach ($array as $values) {

        //при первом проходе первый <tr>
        if ($i == 1) {
            echo '<tr>';
        }

        echo "<td> $values </td>";

        //если счетчик прохода массива кратен нужному колличеству колонок, - закрываем <tr> и открываем новый
        if ($i % $num_columns == 0) {
            echo '</tr>';
            echo '<tr>';
        }

        //region если последний эллемент массива...
        if ($i == count($array)) {

            //...определяем количество последних элементов в массиве, после последнего нужного кратного. Для создания нужного количества пустых, завершающих, td-шек(ячеек), и вывода рамок вокруг них
            $num_last_td = @count(array_pop(array_chunk($array, $num_columns)));

            //выводим пустые, завершающие, td-шки
            for ($z = $num_columns; $z > $num_last_td; $z--) {
                echo "<td> &nbsp; </td>";
            }

            //последний, завершающий, </tr>
            echo '</tr>';
        }
        //endregion

        $i++;
    }

    ?>

</table>

</body>
</html>
