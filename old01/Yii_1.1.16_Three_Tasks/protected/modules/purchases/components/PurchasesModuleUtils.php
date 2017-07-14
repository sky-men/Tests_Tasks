<?php


class PurchasesModuleUtils
{
    /**
     * Создание необходимых <td>ек для html-таблицы, на основе дат
     *
     * @param integer $start_timestamp стартовый unixtimestamp, от которого проверять дату
     * @param integer $day_interval на сколько дней смещаться от стартовой даты
     * @param integer $check_time проверяемый unixtimestamp. Если он попадает в какие-то сутки от $start_timestamp, до конечного смещения дней $day_interval, - выставляем в эту <td>шку сумму ($purchase->sum)
     * @param DateTimeZone $date_time_zone
     * @param Purchases $purchase
     * @return string готовая строка <td>ек
     */
    public static function createTableTdWithSum($start_timestamp, $day_interval, $check_time, DateTimeZone $date_time_zone, Purchases $purchase)
    {

        $start_day = new DateTime(date('Y-m-d', $start_timestamp), $date_time_zone);

        $td = '';

        for ($i = 0; $i < $day_interval; $i++) {
            if ($i != 0)
                $start_day->modify("-1 day");

            $end_day = new DateTime(date_format($start_day, "Y-m-d"), $date_time_zone);

            $end_day = $end_day->modify("+1 day");

            if ($start_day->getTimestamp() <= $check_time and $check_time < $end_day->getTimestamp()) {
                $td .= "<td>{$purchase->sum}</td>";
            } else
                $td .= "<td>0</td>";
        }

        return $td;
    }

    public static function convertPHPTimeZoneToMySQL()
    {
        $now = new DateTime();

        $mins = $now->getOffset();

        $sgn = ($mins < 0 ? -1 : 1);

        $mins = abs($mins);

        $hrs = floor($mins / 60);

        $mins -= $hrs * 60;

        return sprintf('%+d:%02d', $hrs*$sgn, $mins); //offset
    }

    public static function createDateForSqlWhere()
    {
        $sql = '';

        if(!empty($_GET['from'])) {
            $date = self::convertStrDateToUnixTimestamp($_GET['from']);

            if(!$date)
                return false;

            $sql = "WHERE ts_day_start >= $date";
        }

        if(!empty($_GET['to'])) {
            $date = self::convertStrDateToUnixTimestamp($_GET['to'], true);

            if(!$date)
                return false;

            if(!empty($sql))
                $sql .= " AND  ts_day_start <= $date";
            else
                $sql = "WHERE ts_day_start <= $date";
        }

        return $sql;
    }

    public static function convertStrDateToUnixTimestamp($str, $all_day = false)
    {
        $date = explode('.', $str);

        foreach ($date as $value){
            if(!is_numeric($value))
                return false;
        }

        if($all_day)
            return strtotime("$date[2]-$date[1]-$date[0] 23:59:59");
        else
            return strtotime("$date[2]-$date[1]-$date[0]");
    }
}