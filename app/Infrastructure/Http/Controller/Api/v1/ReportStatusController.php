<?php

namespace App\Infrastructure\Http\Controller\Api\v1;

use App\Application\UseCase\Api\v1\ReportStatus;
use App\Application\UseCase\Api\v1\Request\ReportStatusRequest;
use App\Application\UseCase\Api\v1\Response\ReportStatusResponse;
use App\Domain\Exception\TransactionNotFoundException;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Http\Controller\Controller;
use App\Infrastructure\Repository\QueueReportRepository;

class ReportStatusController extends Controller
{
    /**
     * @throws TransactionNotFoundException
     */
    protected function execute(...$args)
    {
        $repository = new QueueReportRepository(DatabaseConnection::getInstance());

        if (!$uid = $args['uid']) {
            throw new TransactionNotFoundException();
        }

        $request = new ReportStatusRequest($uid);

        /**
         * @var ReportStatusResponse $status
         */
        $response = (new ReportStatus($repository))($request);

        return json_encode(['status' => $response->status->value]);
    }
}
