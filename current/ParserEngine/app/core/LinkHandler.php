<?php


namespace app\core;

use app\core\helpers\UrlHelper;

/**
 * Class LinkHandler класс для работы со ссылками
 *
 * @package app\core
 */
class LinkHandler
{
    /**
     * @var array хост, который парсится
     */
    protected $host = false;

    /**
     * @var array массив со списком отпарсеных URL-ов и которых надо отпарсить
     */
    protected $links;


    /**
     * Конструктор
     * @param string $startUrl стартовый URL, с которого начинается парсинг
     */
    public function __construct(string $startUrl)
    {
        $this->host = UrlHelper::getHost($startUrl);
    }


    /**
     * Добавить url для дальнейшего парсинга
     *
     * @param string $url
     * @return bool
     */
    public function addLink(string $url): bool
    {
        $url = UrlHelper::unifyUrl($url);

        if (!UrlHelper::checkURL($url, $this->host['host']))
            return false;

        $url_hash = $this->createUrlHash($url);

        //если url-а с таким hash-ем нет ни в очереди ни в отпарсеных, - добавить в очередь
        if (!isset($this->links['parsing'][$url_hash]) and !isset($this->links['parsed'][$url_hash]))
            $this->links['parsing'][$url_hash] = $url;
        else
            return false;

        return true;
    }

    /**
     * Добавить url в уже отпарсеные и удалить его из очереди
     *
     * @param array $link принимает массив 'hash'=>'url'
     * @return bool
     */
    public function addParsedLink(array $link): bool
    {
        $hash = $link['hash'];

        if (isset($this->links['parsed'][$hash]))
            return false;

        $this->links['parsed'][$hash] = $link['url'];

        unset($this->links['parsing'][$hash]);

        return true;
    }

    /**
     * Получить hash и url страницы для следующего парсинга
     *
     * @return array
     */
    public function getNextParsingUrl(): ?array
    {
        if (empty($this->links['parsing']))
            return null;

        $result = [
            'hash' => key($this->links['parsing']),
            'url' => current($this->links['parsing'])
        ];

        return $result;
    }


    /**
     * Отпарсить ссылки из <a> тега и добавить их в список для парсинга
     *
     * @param array $page
     * @return bool
     */
    public function parseLinks(array $page): bool
    {
        $preg = '~<a.+?href=["\'](.+?)["\']~i';

        preg_match_all($preg, $page['content'], $pockets);

        if (empty($pockets[1]))
            return false;

        foreach ($pockets[1] as $key => $url) {
            //если ссылка не url, считаем что это, возможно, URI
            if (!UrlHelper::checkURL($url))
                $url = UrlHelper::createInnerURL($page['info']['url'], $url);

            $this->addLink($url);
        }

        return true;
    }


    /**
     * Сформировать hash по строке url-а
     *
     * @param string $url
     * @return string
     */
    public function createUrlHash(string $url): string
    {
        $url = rtrim($url, '/');

        return md5($url);
    }


    /**
     * Вернуть имя хоста, который парсится
     *
     * @return array
     */
    public function getHost(): array
    {
        return $this->host;
    }


    /**
     * Получить статистику. Можно реализовать отдельными счетчиками
     *
     * @return array
     */
    public function getStat()
    {
        return [
            'amountParsingLinks' => count($this->links['parsing']),
            'amountParsedLinks' => count($this->links['parsed']),
        ];
    }

}