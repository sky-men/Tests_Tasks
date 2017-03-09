<?php

Class Utils
{
    public static function redirect($location = '/', array $message = null)
    {
        if(!empty($message))
            $_SESSION[$message['type']] = $message['text'];

        header ("Location: $location");

        exit;
    }

    /**
     * Простейшая отправка почты без указания кодировки и HTML
     */
    public static function mail($to, $from, $subject, $text)
    {
        $headers = 'From:'.$from . "\r\n" .
            'Reply-To:'.$from . "\r\n" .
            'X-Mailer: PHP/'. "\r\n" .
            "Content-type:text/plain". "\r\n";

        if (!mail($to, $subject, $text, $headers))
            throw new Exception("Can't send email");
    }

    public static function getRandomString($length = 10, $allow_uppercase = true, $allow_numbers = true)
    {
        $out = '';

        $arr = array();

        for($i=97; $i<123; $i++)
            $arr[] = chr($i);

        if ($allow_uppercase) {
            for ($i = 65; $i < 91; $i++)
                $arr[] = chr($i);
        }

        if ($allow_numbers) {
            for ($i = 0; $i < 10; $i++)
                $arr[] = $i;
        }

        shuffle($arr);

        for($i=0; $i<$length; $i++)
            $out .= $arr[mt_rand(0, sizeof($arr)-1)];

        return $out;
    }
}