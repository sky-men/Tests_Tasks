<?php

class Bootstrap
{
    public static function init()
    {
        session_start();

        require_once 'tsh.php';

        (new TSH)->Run(array('handling' => 'both', 'tags' => 'strip', 'quotes' => 'strip'));
    }

}