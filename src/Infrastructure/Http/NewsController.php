<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Application\UseCase\CreateNews;
use App\Application\UseCase\GetNews;
use App\Application\UseCase\GenerateReport;
use App\Application\UseCase\Request\CreateNewsRequest;

class NewsController extends AbstractFOSRestController
{
    public function __construct(
        private CreateNews $createNewsUseCase,
        private GetNews $getNewsUseCase,
        private GenerateReport $generateReportUseCase
    ) {}

    /**
     * @Rest\Post("/api/v1/news/create")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param CreateNewsRequest $request
     * @return Response
     */
    public function create(CreateNewsRequest $request): Response
    {
        try {
            $response = ($this->createNewsUseCase)($request);
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
     * @Rest\Get("/api/v1/news/list")
     * @return Response
     */
    public function getList(): Response
    {
        try {
            $response = ($this->getNewsUseCase)();
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
     * @ParamConverter("request", class="array", converter="fos_rest.request_body")
     * @param array $request
     * @return Response
     */
    public function getReport(array $request): Response
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
