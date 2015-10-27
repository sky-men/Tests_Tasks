<?php
require_once 'app/db/get.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script type="application/javascript" src="js/jquery/jquery-2.1.4.min.js"></script>
    <script type="application/javascript" src="js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/jquery/jquery.editable.min.js"></script>

    <script type="application/javascript" src="js/dom.js"></script>

    <link href="js/jquery/jquery-ui-1.11.4/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>

    <title>JS работа с DOMмиками</title>

</head>
<body>

<span id="content">

        <?php
        if (!empty($tree['value']))
            echo $tree['value'];
        else { ?>
            <span id="tree" new="true">

                <span>
                    <div class="title">Вася</div>

                    <span>
                       <div class="title">Дуся</div>
                    </span>

                    <span>
                       <div class="title">Маруся</div>
                    </span>
                </span>

                <span>Петя</span>

                <span>Ваня</span>
                <span>Люся</span>
                <span>Катя</span>
                <span>Пуся</span>

            </span>
        <?php } ?>

    <div id="action_btn_container" style="display: none">
        <div class="action_btn">
            <img src="img/slide.png" class="slide_btn" title="Свернуть/Развернуть">
            <img src="img/add.png" class="add_btn" title="Добавить">
            <img src="img/rem.png" class="rem_btn" title="Удалить">
        </div>
    </div>

</span>

</body>
</html>