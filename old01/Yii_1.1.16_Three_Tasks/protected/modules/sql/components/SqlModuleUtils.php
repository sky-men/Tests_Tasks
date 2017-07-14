<?php


class SqlModuleUtils
{
    /**
     * Создать даты с шагом в 1 день, на основе минимальной и максимальной даты в записях биллинга
     *
     * @return array|bool
     */
    public static function createDatesBasedBilling()
    {
        $db = Yii::app()->db;

        $first_date = $db->createCommand('SELECT MIN(date) AS date FROM billing')->queryRow();

        $last_date = $db->createCommand('SELECT MAX(date) AS date FROM billing')->queryRow();

        if (empty($first_date['date']) or empty($last_date['date']))
            return false;

        $first_date = new DateTime($first_date['date']);

        $last_date = new DateTime($last_date['date']);

        while ($first_date <= $last_date) {
            $dates[] = $first_date->format('Y-m-d');
            $first_date->add(new DateInterval('P1D'));
        }
        unset($first_date, $last_date);

        return $dates;
    }

    /**
     * Формирование ANDов фильтрующего диапазона дат для sql-запроса
     *
     * @return string
     */
    public static function getAndForQuery()
    {
        //region
        $filter_dates['start_date'] = (!empty($_POST['start_date'])) ? htmlspecialchars($_POST['start_date'], ENT_QUOTES) : null;

        $filter_dates['end_date'] = (!empty($_POST['end_date'])) ? htmlspecialchars($_POST['end_date'], ENT_QUOTES) : null;

        $and = '';

        if ($filter_dates['start_date'])
            $and .= " AND billing.date >= '{$filter_dates['start_date']}' ";

        if ($filter_dates['end_date'])
            $and .= " AND billing.date <= '{$filter_dates['end_date']}' ";
        //endregion

        return $and;
    }
}