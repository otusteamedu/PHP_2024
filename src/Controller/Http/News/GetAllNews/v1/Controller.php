<?php

namespace App\Controller\Http\News\GetAllNews\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly ControllerManager $manager,
    ) {
    }

    #[Route(path: 'api/v1/news/all', methods: ['GET'])]
    public function __invoke(): Response
    {
        $result = ($this->manager)();
        $response = new JsonResponse($result, $result ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        return $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
