<?php

class Utils
{
    public static function additionalSecurity(array $array)
    {
        $array = array_map(function($param) {
            return htmlspecialchars($param, ENT_QUOTES);
        },$array);

        return $array;
    }
}