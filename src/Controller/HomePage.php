<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class HomePage
{
    #[Route(path: '/', methods: ['GET'])]
    public function hello(): Response
    {
        return new Response('<html><body><h1><b>It works!</b></h1></body></html>');
    }
}
