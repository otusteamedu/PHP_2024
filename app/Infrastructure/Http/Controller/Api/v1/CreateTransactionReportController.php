<?php

namespace App\Infrastructure\Http\Controller\Api\v1;

use App\Application\UseCase\Api\v1\CreateTransactionReport;
use App\Application\UseCase\Api\v1\Request\CreateTransactionReportRequest;
use App\Infrastructure\Http\Controller\Controller;
use Exception;

class CreateTransactionReportController extends Controller
{
    /**
     * @throws Exception
     */
    public function createTransactionReport(...$request): string
    {
        $request = new CreateTransactionReportRequest(
            $request['dateFrom'],
            $request['dateTo'],
            $request['accountFrom'],
            $request['accountTo'],
            $request['transactionType'],
            $request['transactionStatus']

        );

        $report = (new CreateTransactionReport())($request);

        header('Content-Type: application/json');

        return json_encode(['uid' => $report->uid]);
    }
}