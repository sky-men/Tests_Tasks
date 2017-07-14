<?php

/**
 * Class Process вспомогательный класс для работы с процессом ОС, который выполняет импорт по конкретному магазину
 */
class Process
{
    public $shop;

    public $pid_dir;

    protected $pid_file = null;

    protected $pid_handle = null;

    /**
     * @param string $shop ожидается передача названия магазина, с которым сейчас происходит работа
     */
    public function __construct($shop)
    {
        require_once 'Utils.php';

        if(empty($shop))
            Utils::ShowError('shop is empty');

        $this->shop = $shop;

        $this->pid_dir = realpath(__DIR__.'/../pids');
    }

    /**
     * удаляем pid-файл
     */
    public function __destruct()
    {
        if($this->pid_handle)
            fclose($this->pid_handle);

        if($this->pid_file)
            unlink($this->pid_file);
    }

    /**
     * Предварительные действия перед началом основной работы.
     * Создаем файл "магазин_pid" и лочим его
     *
     * @return bool
     */
    public function startWork()
    {
        $this->pid_file = $this->pid_dir.'/'.$this->shop.'_'.getmypid();

        $result = file_put_contents($this->pid_file, '');

        if ($result === false)
            Utils::ShowError("Can't create file $this->pid_file");

        $this->pid_handle = fopen($this->pid_file, 'r');

        flock($this->pid_handle, LOCK_EX);

        return true;
    }

    /**
     * Проверить запущен ли предыдущий процесс для установленного магазина
     *
     * @return bool возвращяет true если запущен
     */
    public function isRunning()
    {
        //получаем все файлы в директории с pid-ами
        $files = scandir($this->pid_dir);

        //ищем есть ли файл относящийся к текущему магазину
        $files = array_filter($files, function ($value) {
            if (stripos($value, $this->shop . '_') !== false)
                return true;
            else
                return false;
        });

        //если такого файла нет, - значит предыдущий процесс не запущен
        if (!$files)
            return false;

        //если такой файл есть, проверяем запущен ли процесс с таким pid-ом

        $pid_file = array_pop($files);

        //из имени файла извлекаем PID процесса
        $pid = substr($pid_file, strrpos($pid_file, '_') + 1);

        //проверяем запущин ли процесс (под Windows или Linux). $result == true: запущен
        if (!defined('PHP_WINDOWS_VERSION_MAJOR'))
            $result = posix_getpgid($pid);
        else
        {
            exec("tasklist /FI \"PID eq $pid\" 2>nul|Find /I \"$pid\"", $out);

            $result = ($out) ? true : false;
        }

        if ($result)
            return true;
        else //если не запущен удаляем ненужный файл и возвращяем false
        {
            unlink($this->pid_dir.'/'.$pid_file);
            return false;
        }
    }
}