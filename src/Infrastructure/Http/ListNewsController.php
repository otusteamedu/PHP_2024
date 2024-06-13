<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Query\GetNewsQuery;
use Ecotone\Modelling\QueryBus;

class ListNewsController extends AbstractFOSRestController
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    /**
     * @Rest\Get("/api/v1/news/list")
     * @return Response
     */
    public function getAction(): Response
    {
        try {
            $response = $this->queryBus->send(new GetNewsQuery());
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }

        return $this->handleView($view);
    }
}
