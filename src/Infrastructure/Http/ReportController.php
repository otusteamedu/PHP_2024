<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Query\GetReportQuery;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Ecotone\Modelling\CommandBus;
use App\Application\Command\GenerateReportCommand;
use Ecotone\Modelling\QueryBus;

class ReportController extends AbstractFOSRestController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus
    ) {}

    /**
     * @Rest\Post("/api/v1/news/report")
     * @ParamConverter("request", class="array", converter="fos_rest.request_body")
     * @param array $request
     * @return Response
     */
    public function generateAction(array $request): Response
    {
        try {
            $response = $this->commandBus->send(new GenerateReportCommand($request['id']));
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/v1/news/report")
     * @return Response
     */
    public function getReportAction(): Response
    {
        try {
            $response = $this->queryBus->send(new GetReportQuery());
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
