<?php

declare(strict_types=1);

namespace App\Application\Handler\Query;

use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\Request\ReportGeneratorRequest;
use App\Application\Handler\Response\GenerateReportResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Ecotone\Modelling\Attribute\QueryHandler;
use App\Application\Query\GenerateReportQuery;

class GenerateReportQueryHandler
{
    public function __construct(
        private ParameterBagInterface $params,
        private NewsInterface $newsRepository,
        private ReportGeneratorInterface $reportGenerator
    ) {}

    #[QueryHandler]
    public function __invoke(GenerateReportQuery $query): GenerateReportResponse
    {
        $news = $this->newsRepository->findByParams([
            'id' => $query->getIds()
        ]);
        $titles = array_map(fn(News $item) => $item->getTitle(), $news);
        $generatorResponse = $this->reportGenerator->generate(new ReportGeneratorRequest($titles));

        return new GenerateReportResponse($this->params->get('app.base_url') . $generatorResponse->filePath);
    }
}
