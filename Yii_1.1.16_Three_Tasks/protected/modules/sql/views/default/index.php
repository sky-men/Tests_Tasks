<?php
$this->pageTitle = 'Работа с СУБД MySQL';

Yii::app()->clientScript->registerScriptFile('/js/jquery/jquery-2.1.4.min.js');
Yii::app()->clientScript->registerScriptFile('/js/sql_module.js');

echo "<div class='cms_title'>{$this->pageTitle}</div>";

if (!empty(Yii::app()->user->errors)) {
    foreach (Yii::app()->user->errors as $errors){
        $error = $errors[0];
        break;
    }
    echo "<div class='cms_errorMessage'>$error</div>";
    unset(Yii::app()->user->errors);
}

if (!empty(Yii::app()->user->message)) {
    echo "<div class='cms_message'>" . Yii::app()->user->message . "</div>";
    unset(Yii::app()->user->message);
}


?>

<div class="cms_content">
    <div class="sql_import_block"><a href="<?= $this->createUrl('/sql/default/import') ?>">Импорт данных из txt-файлов</a></div>

    <div class="sql_range_date">
        <form method="post" enctype="application/x-www-form-urlencoded">
            <span>с</span>

            <select name="start_date">
                <?php
                if (!empty($dates)) {
                    foreach ($dates as $date) {
                        $selected = (!empty($_POST['start_date']) and $_POST['start_date'] == $date) ? 'selected="selected"' : '';
                        echo "<option value='$date' $selected >$date</option>";
                    }
                }
                ?>
            </select>

            <span>по</span>

            <select name="end_date">
                <?php
                if (!empty($dates)) {
                    foreach ($dates as $date) {
                        $selected = (!empty($_POST['end_date']) and $_POST['end_date'] == $date) ? 'selected="selected"' : '';
                        echo "<option value='$date' $selected >$date</option>";
                    }
                }
                ?>
            </select>

            <input type="submit" value="Выбрать">
        </form>
    </div>

    <div>
        <table class="sql_tbl">
            <tr class="sql_tbl_title">
                <td>Группа</td>
                <td>Сервис</td>
                <td>Сумма</td>
            </tr>

            <?php
            if (!empty($data)) {
                $sum = 0;
                foreach ($data as $value) {
                    $sum = $sum + $value['sum'];
                    echo '<tr>';
                    echo "<td> $value[service_group_name] </td>";
                    echo "<td> $value[service_name] </td>";
                    echo "<td class='sql_sum'>" . round($value['sum'], 2) . "</td>";
                    echo '</tr>';
                }
                echo "<tr><td colspan='3' class='sql_sum'>" . round($sum, 2) . "</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="sql_add_service">
        <form action="<?=$this->createUrl('/sql/default/addService') ?>" method="post" enctype="application/x-www-form-urlencoded">
            <input type="text" name="service_name" value="Имя сервиса" onfocus="if(this.value =='Имя сервиса') this.value = ''">
            <?= CHtml::dropDownList('service_group_id', 'selected', CHtml::listData(ServiceGroup::model()->findAll(), 'service_group_id', 'service_group_name'), array('id'=>false)) ?>
            <input type="submit" value="Добавить">
        </form>
    </div>

    <div class="sql_service_block">
        <div class="sql_service_title">Изменение регистра первых букв, в наименовании сервисов по клику</div>
        <?php
        if(!empty($services)){
            echo '<ul>';
            foreach ($services as $service){
                echo "<li id='service_{$service->service_id}'>{$service->service_name}</li>";
            }
            echo '</ul>';
        }
        ?>
    </div>

</div>