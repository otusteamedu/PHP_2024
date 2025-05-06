<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class SimpleController
{
    #[Route(path: '/', methods: ['POST'])]
    public function __invoke()
    {
        // TODO вызвать сервис, который добавляет задание в очередь
        return 'Hello World!';
    }
}
