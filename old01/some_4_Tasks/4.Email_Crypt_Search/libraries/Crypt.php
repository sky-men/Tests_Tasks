<?php

class Crypt
{
    protected static $key = 'Tdf8541_fIFRx';

    public static function encryptText($text)
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$key, $text, MCRYPT_MODE_ECB, $iv);

        $text = base64_encode($text);

        return $text;
    }

    public static function decryptText($text)
    {
        $text = base64_decode($text);

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $text = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$key, $text, MCRYPT_MODE_ECB, $iv);

        $text = rtrim($text, "\0\4");

        $text = rtrim($text, "\0");

        return $text;
    }
}