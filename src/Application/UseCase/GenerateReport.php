<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Helper\ReportGeneratorInterface;
use App\Application\Helper\Request\ReportGeneratorRequest;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use App\Application\UseCase\Response\GenerateReportResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GenerateReport
{
    public function __construct(
        private ParameterBagInterface $params,
        private NewsInterface $newsRepository,
        private ReportGeneratorInterface $reportGenerator
    ) {}

    public function __invoke(array $ids): GenerateReportResponse
    {
        $news = $this->newsRepository->findBy([
            'id' => $ids
        ]);
        $titles = array_map(fn(News $item) => $item->getTitle(), $news);
        $generatorResponse = $this->reportGenerator->generate(new ReportGeneratorRequest($titles));

        return new GenerateReportResponse($this->params->get('app.base_url') . $generatorResponse->filePath);
    }
}
