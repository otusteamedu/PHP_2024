<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers\Web;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class HomeController
{
    public function __construct(private Twig $view)
    {
        //
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function home(Request $request, Response $response, array $args): Response
    {
        return $this->view->render($response, 'form.html.twig');
    }
}