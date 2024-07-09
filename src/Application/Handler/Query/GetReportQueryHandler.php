<?php

declare(strict_types=1);

namespace App\Application\Handler\Query;

use App\Application\Handler\Response\GenerateReportResponse;
use App\Application\Query\GetReportQuery;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Ecotone\Modelling\Attribute\QueryHandler;

class GetReportQueryHandler
{
    public function __construct(
        private ParameterBagInterface $params
    ) {}

    #[QueryHandler]
    public function __invoke(GetReportQuery $query): GenerateReportResponse
    {
        return new GenerateReportResponse($this->params->get('app.base_url') . '/uploads/news.html');
    }
}
