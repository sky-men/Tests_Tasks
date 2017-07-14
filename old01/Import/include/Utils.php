<?php

/**
 * Class Utils вспомогательный класс
 */
class Utils
{
    /**
     * Выдать ошибку на консоль в примерно удобоваримом виде и завершить скрипт
     *
     * @param $message
     */
    public static function ShowError($message)
    {
        exit($message." \r\n");
    }


    /**
     * Выдать сообщение на консоль
     *
     * @param $message
     */
    public static function ShowMessage($message)
    {
        self::ShowError($message);
    }
}

