<?php

declare(strict_types=1);

namespace Otus\App;

class Application
{
    public $file;
    public function run()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            (new Validation())->check($_POST["text"]);
            $this->file = 'validation_confirm.html';
        } else {
            $this->file = 'form_validation.html';
        }
        $view = new View($this->file);
        return $view->renderHTML();
    }
}
