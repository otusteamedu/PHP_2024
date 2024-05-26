<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Exception\ReportNotCreatedException;
use App\Application\UseCase\CreateReport;
use App\Application\UseCase\Request\CreateReportRequest;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\NewsRepository;
use App\Infrastructure\Service\ReportFileCreator;

class CreateReportController extends Controller
{
    public function __construct(private readonly ReportFileCreator $reportFileCreator)
    {
        parent::__construct();
    }

    /**
     * @throws ReportNotCreatedException
     */
    public function createReport(...$params): string
    {
        $ids = json_decode($params['ids']);

        $reportRequest = new CreateReportRequest($ids);
        $connection = Connection::getInstance();
        $repository = new NewsRepository($connection);
        $reportContent = (new CreateReport($repository))($reportRequest);

        $fileName = time() . '.html';
        $this->reportFileCreator->createReportFile($fileName, $reportContent);

        return env('APP_HOST') . '/reports/' . $fileName;
    }
}
