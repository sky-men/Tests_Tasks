<?php

Class View
{
    public $dir = APP.'/mvc/views';

    public function render($controller, $action)
    {
        ob_start ();

        require $this->dir."/$controller/$action.php";

        $html = ob_get_contents();

        ob_end_clean();

        return $html;
    }
}