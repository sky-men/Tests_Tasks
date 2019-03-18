<?php

namespace includes\classes;

class Controller
{
    public static function insertData(): string
    {
        $data = self::validateData((array)json_decode($_POST['data']));

        (new Model)->insertData($data);

        return 'Success';
    }

    public static function getData()
    {
        $data = (new Model)->getData();

        return self::convertData($data);
    }

    protected static function validateData(array $data): array
    {
        $data = array_map('strip_tags', $data);

        foreach ($data as &$value)
            $value = preg_replace('~["\']~', '', $value);

        return $data;
    }

    protected static function convertData(array $data, string $type = 'json'): ?string
    {
        if ($type == 'json')
            return json_encode($data);
        elseif ($type == 'csv')
        {
            $file = APP_DIR . '/includes/data/result_data.csv';

            $fp = fopen($file, 'w');

            foreach ($data as $value)
                fputcsv($fp, $value);

            fclose($fp);

            return $file;
        }
        else
            return null;
    }
}