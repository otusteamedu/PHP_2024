<?php

namespace App\Infrastructure\Http\Controller\Api\v1;

use App\Application\UseCase\Api\v1\CreateTransactionReport;
use App\Application\UseCase\Api\v1\Request\CreateTransactionReportRequest;
use App\Infrastructure\Console\QueueConnection;
use App\Infrastructure\Console\QueueMessage;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Http\Controller\Controller;
use App\Infrastructure\Repository\QueueReportRepository;
use Exception;

class CreateTransactionReportController extends Controller
{
    /**
     * @throws Exception
     */
    public function execute(...$request): string
    {
        $request = new CreateTransactionReportRequest(
            $request['dateFrom'],
            $request['dateTo'],
            $request['accountFrom'],
            $request['accountTo'],
            $request['transactionType'],
            $request['transactionStatus']
        );

        $repository = new QueueReportRepository(DatabaseConnection::getInstance());

        $report = new CreateTransactionReport(
            $repository,
            new QueueConnection(),
            new QueueMessage()
        );

        header('Content-Type: application/json');

        return json_encode(['uid' => $report($request)->uid]);
    }
}