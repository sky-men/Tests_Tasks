<?php

namespace Images;

//подключение стороннего resize-а
require_once __DIR__.'/Resize.php';


/**
 * Class Images\Utils. Класс вспомогательных функций для работы с рисунками
 */
class Utils
{
    /**
     * Загрузить рисунок из $_FILES
     *
     * @param string $attribute. Атрибут в $_FILES, который рассматривается как рисунок
     * @param string $dest. Путь к файлу, куда необходимо загрузить рисунок. Если указана папка, - рисунок будет загружен в эту папку, с уникальным именем
     * @param array $resolution ['width'] ['height'] ширина/высота рисунка
     * @param array $thumb - создавать или нет так же превью изображения.
     *    ['dest'] - куда поместить превью. Может быть папкой
     *    ['width'] ['height'] ширина/высота превью
     *
     * @throws \Exception
     * @return array. Возвращает суммарную информацию о загруженном рисунке
     */
    public static function uploadImage($attribute, $dest, array $resolution, array $thumb = null)
    {
        if (empty($attribute))
            throw new \Exception('Attribute is empty');

        if (empty($_FILES) or empty($_FILES[$attribute]))
            throw new \Exception('File in $_FILES not exist');

        $file = $_FILES[$attribute]['tmp_name'];
        
        if (!is_uploaded_file($file))
            throw new \Exception( 'This file has not uploaded');

        //region Если путь к файлу, куда необходимо загрузить рисунок - директория, - сгенерировать полное имя файла в этой директории
        if(is_dir($dest))
        {
            if (!is_writable($dest))
                throw new \Exception("Directory '$dest' is not writable");

            $tmp_file = tempnam($dest, 'img');

            unlink($tmp_file);

            $tmp_file = pathinfo($tmp_file, PATHINFO_FILENAME);

            $dest = $dest.$tmp_file.'.'.pathinfo($_FILES[$attribute]['name'], PATHINFO_EXTENSION);

            unset($tmp_file);
        }
        //endregion

        $result = self::resizeImage($file, $dest, $resolution);

        unlink($file);

        unset($file, $_FILES[$attribute]);

        if($thumb)
        {
            //region проверка массива $thumb
            $allow_key['dest'] = 1;
            $allow_key['resolution'] = 1;

            if (count(array_intersect_key($thumb, $allow_key)) < count($allow_key))
                throw new \Exception("Array 'thumb' is incorrect. Use 'dest' and 'resolution' keys");

            unset($allow_key);

            if(!$thumb['dest'])
                $thumb['dest'] = dirname($dest);
            //endregion

            //если путь к файлу превьюшки, - директория, - сгенерировать полный путь к будущей превьюшке: Имя_файла+"_thumb"
            if(is_dir($thumb['dest']))
                $thumb['dest'] = $thumb['dest'].DIRECTORY_SEPARATOR.pathinfo($dest, PATHINFO_FILENAME).'_thumb.'.pathinfo($dest, PATHINFO_EXTENSION);

            $result['thumb'] = self::resizeImage($dest, $thumb['dest'], $thumb['resolution']);
        }

        return $result;
    }

    /**
     * Провести resize рисунка, если он больше параметров в $resolution, и скопировать его по указанному в $dest пути
     *
     * @param string $src путь к рисунку
     *
     * @param string $dest путь, куда необходимо скопировать рисунок. Если не указан, рисунок $src будет перезаписан
     * Если указана папка, - resize рисунка будет в эту папку, с именем из $dest
     *
     * @param array $resolution ['width'] ['height'] ширина/высота рисунка
     * @throws \Exception
     * @return array
     */
    public static function resizeImage($src, $dest = null, array $resolution)
    {
        if (empty($src) or !file_exists($src) or !is_file($src))
            throw new \Exception("File '$src' not exists");

        if (empty($dest))
            $dest = $src;

        //region Проверка директории на запись
        if(is_dir($dest))
            $dest_dir = $dest;
        else
            $dest_dir = dirname($dest);

        if (!is_writable($dest_dir))
            throw new \Exception("Directory '$dest_dir' is not writable or not exist");
        //endregion

        if (is_dir($dest))
            $dest = $dest . DIRECTORY_SEPARATOR . pathinfo($src, PATHINFO_BASENAME);

        //region Проверка массива $resolution
        $allow_key['width'] = 1;
        $allow_key['height'] = 1;

        if (count(array_intersect_key($resolution, $allow_key)) < count($allow_key))
            throw new \Exception("Array 'resolution' is incorrect. Use 'width' and/or 'height' keys");

        if ((isset($resolution['width']) and !is_integer($resolution['width'])) or (isset($resolution['height']) and !is_integer($resolution['height'])))
            throw new \Exception('width/height must be only integer');

        unset($allow_key);
        //endregion

        $imagesize = getimagesize($src);

        if (empty($imagesize))
            throw new \Exception("Can't get image size. Maybe file '$src' is not image?");

        if (!isset($resolution['width']))
            $resolution['width'] = null;

        if (!isset($resolution['height']))
            $resolution['height'] = null;

        if($imagesize[0] > $resolution['width'] or $imagesize[1] > $resolution['height'])
        {
            $resizer = new \Resize($src, $dest, $resolution['width'], $resolution['height']);

            $resizer->run();
        }
        else
            copy($src, $dest);

        if (!file_exists($dest))
            throw new \Exception("Can't resize the image '$src'");

        return self::getImageInfo($dest);
    }

    /**
     * Получить информацию о рисунке
     *
     * @param string $image путь к файлу рисунка
     * @throws \Exception
     * @return array
     */
    public static function getImageInfo($image)
    {
        if (empty($image) or !file_exists($image) or !is_file($image))
            throw new \Exception("File '$image' not exists");

        $result = getimagesize($image, $info);

        if (empty($result))
            throw new \Exception("Can't get image info. Maybe file '$image' is not image?");

        $result['width'] = $result[0];
        $result['height'] = $result[1];

        $result['filesize'] = filesize($image);

        $result['file'] = $image;

        $result['additional'] = $info;

        return $result;
    }
}
