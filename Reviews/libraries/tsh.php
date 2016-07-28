<?php
/**
 * Класс для защиты принимаемых параметров.
 *   
 * Перебирает все в $_REQUEST, $_POST, $_GET, $_COOKIE  и обрабатывает эти данные функциями trim(), stripslashes(), htmlspecialchars(), strip_tags(), addslashes(). В зависимости от переданных параметров
 * 
 * Принимает массив со следующими параметрами параметры:
    - $param["handling"] => "both" (обрабатывать и теги и кавычки); => "tags" - обрабатывать только теги; => "quotes" - обрабатывать только кавычки;
    - $param["tags"] => "mnemonics" (теги заменять HTML-мнемониками); => "strip" - теги удалять;
    - $param["quotes"]  => "mnemonics" (кавычки заменять HTML-мнемониками); => "slashes" - кавычки экранировать; "strip" - кавычки удалять
 * 
 * Запуск - $TSH->Run();
 *
 * @version 1.0.1
 */
class TSH
{
    public function Run($param = array("handling" => "both", "tags" => "mnemonics", "quotes" => "mnemonics"))
    {
        foreach ($_REQUEST as &$values)
            $this->screening($values, $param);
        foreach ($_POST as &$values)
            $this->screening($values, $param);
        foreach ($_GET as &$values)
            $this->screening($values, $param);
        foreach ($_COOKIE as &$values)
            $this->screening($values, $param);
    }

    public function handlingParam($handl_param, $options = array("handling" => "both", "tags" => "mnemonics", "quotes" => "mnemonics"))
    {
        $this->screening($handl_param, $options);
        return $handl_param;
    }

    protected function screening(&$values, $param)
    {
        if (is_array($values)) {
            foreach ($values as &$values2)
                $this->screening($values2, $param);
        }
        else
        {
            $values = trim($values);

            if (get_magic_quotes_gpc())
                $values = stripslashes($values);
            
            if ($param["handling"] == "both") {
                if ($param["tags"] == "mnemonics" and  $param["quotes"] == "mnemonics")
                    $values = htmlspecialchars($values, ENT_QUOTES);
                elseif ($param["tags"] == "strip")
                    $values = strip_tags($values);
                elseif ($param["tags"] == "mnemonics")
                    $values = htmlspecialchars($values);

                if ($param["quotes"] == "slashes") {
                        $values = addslashes($values);
                }
                elseif ($param["quotes"] == "mnemonics") {
                    $values = str_replace('"', '&quot;', $values);
                    $values = str_replace("'", '&#039;', $values);
                }
                elseif ($param["quotes"] == "strip") {
                    $values = str_replace('"', '', $values);
                    $values = str_replace("'", '', $values);
                }
            }
            elseif ($param["handling"] == "tags")
            {
                if ($param["tags"] = "strip")
                    $values = strip_tags($values);
                elseif ($param["tags"] == "mnemonics")
                    $values = htmlspecialchars($values);
            }
            elseif ($param["handling"] == "quotes")
            {
                if ($param["quotes"] == "slashes") {
                    if (!get_magic_quotes_gpc())
                        $values = addslashes($values);
                }
                elseif ($param["quotes"] == "mnemonics") {
                    $values = str_replace('"', '&quot;', $values);
                    $values = str_replace("'", '&#039;', $values);
                }
                elseif ($param["quotes"] == "strip") {
                    $values = str_replace('"', '', $values);
                    $values = str_replace("'", '', $values);
                }

            }
        }
    }
}

?>