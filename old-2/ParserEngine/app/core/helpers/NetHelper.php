<?php


namespace app\core\helpers;

/**
 * Class NetHelper помощник для сетевых операций
 *
 * @package app\core\helpers
 */
class NetHelper
{
    /**
     * Обвертка для curl-а получающая переданный url
     *
     * @param string $url
     * @param string $main_host ожидается передача домена example.com.
     * Если он передан, то итоговая страница будет возвращяться, после всех редиректов, только если она находится на том же домене (не внешний сайт)
     * @return array 'info'=>'информация о странице',
     *                'content' => 'весь контент страницы'
     */
    public static function getPage(string $url, string $main_host = null): ?array
    {
        $curl = curl_init($url);

        if (substr($url, 0, 5) == "https") {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        }
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);

        $content = curl_exec($curl);

        if (empty($content))
            return null;

        $pageInfo = curl_getinfo($curl);

        if ($main_host and !UrlHelper::checkURL($pageInfo['url'], $main_host))
            return null;

        return [
            'info' => $pageInfo,
            'content' => $content
        ];
    }
}