<?php

namespace Core;

class View
{
    public function generate(string $template, array $data = [])
    {
        $path = __DIR__.'/../Views/'.$template.'.php';
        if (file_exists($path))
            require $path;
        else
            Router::renderPage404();
    }
}