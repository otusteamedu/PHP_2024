<?php

namespace Producer;

use Producer\Controller\FormController;

class Application
{
    public function run(): void
    {
        $controller = new FormController();
        $controller->handleRequest();
    }
}
