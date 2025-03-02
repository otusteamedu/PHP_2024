<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers\Web;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class SwaggerController
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
    public function getSwaggerUi(Request $request, Response $response, array $args): Response
    {
        return $this->view->render($response, 'swagger.html.twig');
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function getOpenApiJson(Request $request, Response $response, array $args): Response
    {
        $openapiJson = file_get_contents(ROOT_PATH . '/openapi.json');
        $response->getBody()->write($openapiJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}