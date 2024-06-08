<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetNewsReportUseCase;
use App\Application\UseCase\Request\GetNewsReportRequest;
use App\Application\UseCase\Response\GetNewsReportResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class GetNewsReportController extends AbstractController
{
    public function __construct(private readonly GetNewsReportUseCase $useCase)
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('api/v1/news-report', name: 'get_news_report', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] GetNewsReportRequest $request): GetNewsReportResponse
    {
        return ($this->useCase)($request);
    }
}
