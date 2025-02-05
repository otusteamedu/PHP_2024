<?php

namespace App\Controller\WebHook;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class Controller
{
    public function __construct(private readonly Handler $handler) {
    }

    public function create(): Response
    {
        return new Response($this->handler->handleUpdate());
    }
}
