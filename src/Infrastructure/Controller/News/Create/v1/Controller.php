<?php

namespace App\Infrastructure\Controller\News\Create\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private ControllerManager $manager,
    ) {
    }

    #[Route(path: 'api/v1/news', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateNewsControllerRequest $request): Response
    {
        return new JsonResponse(($this->manager)($request), Response::HTTP_CREATED);
    }
}
