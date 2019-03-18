<?php

/**
 * Class Parce реализация парсинга для конкретного магазина.
 *
 * Методы должны вернуть одинаковый массив для последующего insert-а в БД
 */
Class Parce
{
    /**
     * csv-магазин
     *
     * @return array|bool
     */
    public static function shop1()
    {
        $source = realpath(__DIR__.'/../import/csv.csv');

        $handle = fopen($source, "r");

        while (($data[] = fgetcsv($handle, 1000, "	")) !== false) {}
        
        fclose($handle);

        if(!$data)
            return false;

        //первую строчку csv файла не учитывать
        array_shift($data);

        if(empty($data))
            return false;

        //формируем итоговый массив для последующего insert-а
        foreach ($data as $key=>$values)
        {
            if($values[2] !== 'Winning Bid (Revenue)')
                continue;

            $result[$key]['shop_id'] = 1;
            $result[$key]['order_id'] = $values[18];
            $result[$key]['status'] = 'approved';
            $result[$key]['sum'] = (int)$values[15];
            $result[$key]['currency'] = 'USD';
            $result[$key]['date'] = $values[11];
        }

        return $result;
    }

    /**
     * xml-магазин
     *
     * @return array|bool
     */
    public static function shop2()
    {
        $source = realpath(__DIR__.'/../import/xml.xml');

        $xml = simplexml_load_file($source);

        if(!$xml)
            return false;

        $i = 0;

        foreach ($xml->stat as $key=>$value)
        {
            $result[$i]['shop_id'] = (int) $value->advcampaign_id;
            $result[$i]['order_id'] = (int) $value->order_id;
            $result[$i]['status'] = (string) $value->status;
            $result[$i]['sum'] = (float) $value->cart;
            $result[$i]['currency'] = (string) $value->currency;
            $result[$i]['date'] = (string) $value->action_date;

            $i++;
        }

        return $result;
    }
}