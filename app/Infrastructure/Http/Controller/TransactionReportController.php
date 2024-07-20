<?php

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Api\v1\CreateTransactionReport;
use App\Application\UseCase\Api\v1\Request\CreateTransactionReportRequest;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Repository\QueueReportRepository;
use Exception;

class TransactionReportController extends Controller
{
    /**
     * @throws Exception
     */
    public function create(...$request): string
    {
        $request = new CreateTransactionReportRequest(
            $request['dateFrom'],
            $request['dateTo'],
            $request['accountFrom'],
            $request['accountTo'],
            $request['transactionType'],
            $request['transactionStatus']

        );

        $repository = new QueueReportRepository((new DatabaseConnection()));

        $report = (new CreateTransactionReport($repository))($request);

        header('Content-Type: application/json');

        return json_encode(['uid' => $report->uid]);
    }
}