<?php

namespace app\core\helpers;

/**
 * Class UrlHelper помощник по работе с url-ами
 *
 * @package app\core\helpers
 */
class UrlHelper
{

    /**
     * "Унифицировать" url - выполнить какие-либо операции, которые будут общими для всех url-ов
     *
     * @param string $url
     * @return string
     */
    public static function unifyUrl(string $url): string
    {
        //якоря в url-ах не надо
        $url = preg_replace('~#.*~', '', $url);

        // заменить '//' на / кроме http(s)://
        $url = preg_replace('~(?<!http|:)//~i', '/', $url);

        return $url;
    }


    /**
     * Обвертка для parse_url() с доп. обработкой
     *
     * @param string $url
     * @return array
     * @throws \Exception
     */
    public static function getHost(string $url): array
    {
        $host = parse_url($url);
        
        $host['host'] = ltrim($host['host'], 'www.');

        if (empty($host['host']))
            throw new \Exception("Can't get host from URL $url");

        $host['host'] = self::unifyUrl($host['host']);

        $host['url_host'] = $host['scheme'].'://'.$host['host'];

        if(isset($host['path'])) {
            $host['dir'] = dirname($host['path']).'/';
            $host['url_dir'] = $host['url_host'].$host['dir'];
        }

        $host['url'] = $url;

        ksort($host);

        return $host;
    }


    /**
     * Обвертка для функции filter_var() с параметром FILTER_VALIDATE_URL
     *
     * @param string $url
     * @param string $mainHost если задан, проверить так же чтобы url принадлежал к данному хосту
     * @return bool
     */
    public static function checkURL(string $url, string $mainHost = null) : bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL))
            return false;

        if ($mainHost){
            $preg = "~^http(s)?://(www.)?$mainHost~i";

            if(!preg_match($preg, $url))
                return false;
        }

        return true;
    }

    /**
     * Создать внутренний URL сайта, рассматривая первый параметр как главную часть (текущая страница), а второй параметр как присоединяемый к нему
     *
     * @param string $mainUrl
     * @param string $innerUri
     * @return string
     */
    public static function createInnerURL(string $mainUrl, string $innerUri)
    {
        $mainUrl = self::getHost($mainUrl);

        if(preg_match('~^\?~', $innerUri))
            return $mainUrl['url'].$innerUri;
        elseif(preg_match('~^/~', $innerUri))
            return $mainUrl['url_host'] . $innerUri;
        elseif(isset($mainUrl['url_dir']))
            return $mainUrl['url_dir'].$innerUri;

        return $mainUrl['url'].$innerUri;
    }

}