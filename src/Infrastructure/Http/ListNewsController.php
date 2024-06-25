<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\ValueObject\Uuid;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @ParamConverter("request", class="array", converter="fos_rest.request_body")
     * @param array $request
     * @return Response
     */
    public function getAction(array $request): Response
    {
        try {
            $response = $this->queryBus->send(new GetNewsQuery(new Uuid($request['uuid'])));
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
