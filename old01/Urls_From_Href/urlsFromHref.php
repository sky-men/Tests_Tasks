<?php
/**
 * Задача:
 *
 * Написать php скрипт, который будет запускаться из консоли.
 *
 * Команда php urlsFromHref.php http://someSite.com/ выводит все ссылки (href атрибуты тега <a>), которые есть на странице http://someSite.com/.
 *
 * Url должны преобразовываться к абсолютной форме, дубликатов быть не должно.
 *
 * Пример запуска:
 *   php urlsFromHref.php https://www.yandex.ru/
 *   php urlsFromHref.php http://rutracker.org/
 */

if (empty($argv[1])) {
    exit('Please specify the url');
}

/**
 * Обвертка для CURLа
 *
 * @param string $link линк страницы, с которой надо получить URLы
 *
 * @return string|bool
 */
function curl($link)
{
    $curl = curl_init($link);

    if (substr($link, 0, 5) == "https") {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    $content = curl_exec($curl);
    curl_close($curl);

    return $content;
}

/**
 * Функция обработки полученых URLов
 *
 * @param array $urls
 * @param string $main_link
 *
 * @return array
 */
function handleUrls(array $urls, $main_link)
{
    foreach ($urls as $key => $values) {

        //region удалить пустые
        $values = trim($values);

        if (empty($values)) {
            unset($urls[$key]);
            continue;
        }
        //endregion

        //region если url начинается с http или www, - считаем его абсолютным и ничего не делаем
        $preg = '~^(http)|(www)~i';

        if (preg_match($preg, $values))
            continue;
        //endregion

        //region если url не начинается с главного url-а, - добавляем нему это url (делаем абсолютным)
        $preg = "~^".preg_quote($main_link)."~i";

        if (!preg_match($preg, $values)){
            $urls[$key] = $main_link.$values;
            continue;
        }
        //endregion
    }

    //удаляем дубли
    $urls = array_unique($urls);

    return $urls;
}

$link = $argv[1];

//получение контента страницы
$content = curl($link);

if (empty($content)) {
    exit("Can't connect to URL $link");
}

//region Получение всех URLов из href-ов контента страницы
$preg = '~<a.+?href=["\'](.*?)["\'].*?>~i';

preg_match_all($preg, $content, $pockets);

if (empty($pockets[1])) {
    exit("Can't get URLs from $link");
}
//endregion

//обработка данных URLов
$urls = handleUrls($pockets[1], $link);

print_r ($urls);