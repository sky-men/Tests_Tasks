<?php
namespace app\core;

use app\core\helpers\UrlHelper;
use app\core\helpers\NetHelper;

/**
 * Class BaseParser базовый класс парсинга
 *
 * @package app\core
 */
abstract class BaseParser
{
    /**
     * @var \app\core\LinkHandler
     */
    protected $linkHandler;

    /**
     * @var string стартовый URL, с которого начинается парсинг
     */
    protected $startURL;

    /**
     * @var array 'hash'=>'url' текущей страницы для парсинга
     */
    protected $currentURL;

    public function __construct()
    {
        if (PHP_VERSION_ID < 70100)
            throw new \Exception('Incorrect PHP version. Need at least 7.1.0');

        $this->startURL = $this->startURL();
    }


    /**
     * Входная функция запуска парсинга
     *
     * @throws \Exception
     */
    public function run()
    {
        $url = $this->startURL;

        if(!UrlHelper::checkURL($url))
            throw new \Exception("Incorrect URL: '$url'");

        $this->linkHandler = new LinkHandler($url);
        
        $this->linkHandler->addLink($url);

        $this->runMainWorker();
    }

    /**
     * Основная функция цикла парсинга
     *
     * @return bool
     */
    protected function runMainWorker() : bool
    {
        //пока есть ссылки для парсинга, - парсим
        while (true)
        {
            $url = $this->linkHandler->getNextParsingUrl();

            if(!$url)
                break;

            $host = $this->linkHandler->getHost();

            $this->currentURL = $url;

            $this->message("Start parsing URL $url[url]...");

            $page = NetHelper::getPage($url['url'], $host['host']);

            $this->linkHandler->addParsedLink($url);

            if(empty($page)) {
                $this->message("Can't get content from $url[url]");
                continue;
            }

            $this->linkHandler->parseLinks($page);

            $this->parse($page);

            $this->message("URL $url[url] has been parsed", true);

            $this->message("\r\n");

            //задержка перед парсингом следующей страницы
            sleep(1);
        }

        $this->message("Parsing completed", true);

        return true;
    }

    /**
     * Вывести сообщение на консоль
     *
     * @param string $message
     * @param bool $stat добавить ли текущую статистику к сообщению
     */
    protected function message(string $message, bool $stat = false)
    {
        echo "$message \r\n";

        if($stat) {
            $stat = $this->linkHandler->getStat();

            echo "Stat: Links for parsing: $stat[amountParsingLinks]. Parsed links: $stat[amountParsedLinks] \r\n";
        }
    }


    /**
     * Абстрактный метод для конкретной реализации парсинга
     *
     * @param array $page парадается весь контент + информация текущей страницы
     * @return mixed
     */
    abstract function parse(array $page): bool;


    /**
     * Наследуемый класс должен вернуть данным методом начальный URL для парсинга
     *
     * @return string
     */
    abstract function startURL(): string;
}