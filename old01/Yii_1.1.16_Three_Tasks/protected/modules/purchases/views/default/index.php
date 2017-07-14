<?php
$this->pageTitle = 'Покупки';

Yii::app()->clientScript->registerCssFile('/js/jquery/jquery-ui/jquery-ui-1.11.4.cupertino-theme.css');

Yii::app()->clientScript->registerScriptFile("/js/jquery/jquery-2.1.4.min.js");
Yii::app()->clientScript->registerScriptFile("/js/jquery/jquery-ui/jquery-ui-1.11.4.js");
Yii::app()->clientScript->registerScriptFile("/js/jquery/jquery-ui/datepicker-ru.js");
Yii::app()->clientScript->registerScriptFile("/js/jquery/jquery.tablesorter.min.js");
Yii::app()->clientScript->registerScriptFile("/js/jquery/jquery.blockUI.js");

Yii::app()->clientScript->registerScriptFile("/js/purchases_module.js");

echo "<div class='cms_title'>{$this->pageTitle}</div>";

if (!empty(Yii::app()->user->errors)) {
    foreach (Yii::app()->user->errors as $errors) {
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
    <div class="sql_import_block"><a href="<?= $this->createUrl('/purchases/default/generateData') ?>">Сгенерировать новые данные</a></div>

    <div class="purchases_filer_block">
        <form enctype="application/x-www-form-urlencoded" method="get" id="filer">
            От <input type="text" name="from" id="from" value="<?= (!empty($_GET['from'])) ? $_GET['from'] : '' ?>">
            До <input type="text" name="to" id="to" value="<?= (!empty($_GET['to'])) ? $_GET['to'] : '' ?>">
            <input type="submit" value="OK">
        </form>
    </div>

    <div>
        <table id="purchases_tbl">
            <thead>
                <tr>
                    <th>pm_id</th>
                    <th>price</th>
                    <?
                    $date = new DateTime(date('Y-m-d', $min_max_time['max']), $date_time_zone);

                    for ($i = 0; $i < $td_num; $i++) {
                        if ($i != 0)
                            $date->modify("-1 day");

                        echo "<td>" . date_format($date, "d.m.Y") . "</td>";
                    }
                    ?>

                </tr>
            </thead>
            <tbody>
            <?
            foreach ($purchases as $purchase) {
                echo "<tr>\r\n";
                echo "<td>{$purchase->pm_id}</td>";
                echo "<td>{$purchase->price}</td>";
                echo PurchasesModuleUtils::createTableTdWithSum($min_max_time['max'], $td_num, $purchase->ts_day_start, $date_time_zone, $purchase);
                echo "\r\n </tr> \r\n";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div>
        <?php $this->widget('CLinkPager', array(
            'pages' => $pages,
        )) ?>
    </div>

</div>
