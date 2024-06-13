<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Ecotone\Modelling\CommandBus;
use App\Application\Command\CreateNewsCommand;

class NewsController extends AbstractFOSRestController
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    /**
     * @Rest\Post("/api/v1/news/create")
     * @ParamConverter("request", class="array", converter="fos_rest.request_body")
     * @param array $request
     * @return Response
     */
    public function createAction(array $request): Response
    {
        try {
            $response = $this->commandBus->send(new CreateNewsCommand($request['url']));
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
