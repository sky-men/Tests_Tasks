<?php

class View
{
    public $file;

    public function render(array $variables = null)
    {
        if ($variables) {
            foreach ($variables as $key => $variable)
                $$key = $variable;
        }

        ob_start();

        require $this->file;

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}