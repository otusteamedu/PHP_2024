<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Application\UseCase\GenerateReport;

class ReportController extends AbstractFOSRestController
{
    public function __construct(
        private GenerateReport $generateReportUseCase
    ) {}

    /**
     * @Rest\Get("/api/v1/news/report")
     * @ParamConverter("request", class="array", converter="fos_rest.request_body")
     * @param array $request
     * @return Response
     */
    public function generateAction(array $request): Response
    {
        try {
            $response = ($this->generateReportUseCase)($request['id']);
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
