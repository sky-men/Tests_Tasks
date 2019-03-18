<?php

namespace app\parsers;

use \app\core\BaseParser;

/**
 * Class RuTrackerParser возможный пример реализации парсинга конкретного сайта, с сохранением в БД через ORM
 *
 * @package app\parsers
 */
class RuTrackerParser extends BaseParser
{

    /**
     * @return string возвращяем начальный URL для парсинга
     */
    public function startURL(): string
    {
        return 'https://rutracker.org';
    }


    /**
     * Главный метод парсинга
     *
     * @param array $page получает массив вида 'info'=>'инфа о странице', 'content'=>'контент страницы'
     * @return bool
     */
    public function parse(array $page): bool
    {
        require_once 'db/config.php'; //подключение и инициализация модели

        $model = new Model();

        $model->url_hash = $this->currentURL['hash'];

        $model->url = $this->currentURL['url'];

        $result = $this->parseAndSetData($page, $model);

        if($result)
            $model->save();

        return true;
    }

    /**
     * Отпарсить конкретные данные и установить их в модель
     *
     * @param array $page
     * @param Model $model
     * @return bool
     */
    protected function parseAndSetData(array &$page, Model $model): bool
    {
        //Отпарсить <title> и <body>
        $pregs['title'] = '~(<title.*?>.+?</title>)~i';
        $pregs['body'] = '~(<body.*?>[\s\S]+?</body>)~i';

        foreach ($pregs as $tbl_cell=>$preg){
            preg_match($preg, $page['content'], $data);

            if(empty($data)) {
                $this->message("Can't get $tbl_cell from {$this->currentURL['url']}");
                return false;
            }

            $text = $this->handleText($data[1]);

            $model->$tbl_cell = $text;
        }

        return true;
    }

    /**
     * Обработки текста
     *
     * @param string $text
     * @return string
     */
    protected function handleText(string $text): string
    {
        $text = iconv('WINDOWS-1251', 'UTF-8', $text);

        $text = preg_replace([
            '~<script.*?>[\s\S]+?</script>~i',
            '~<style.*?>[\s\S]+?</style>~i',
        ], '', $text);

        $text = strip_tags($text);

        $text = preg_replace('~\s+~i', ' ', $text);

        $text = addslashes($text);

        return $text;
    }
}