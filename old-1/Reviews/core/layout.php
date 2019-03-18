<?php

class Layout
{
    public $file = null;

    public function render(array $variables = null)
    {
        foreach ($variables as $key=>$variable)
            $$key = $variable;

        if($this->file)
            require $this->file;
    }
}