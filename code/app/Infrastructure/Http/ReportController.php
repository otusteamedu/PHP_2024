<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\Report\ReportRequest;
use App\Application\UseCase\Report\ReportUseCase;
use Illuminate\Http\Request;

class ReportController
{
    public function __construct(
        private ReportUseCase $reportUseCase
    ) {}

    public function __invoke(Request $httpRequest)
    {
        $rawIds = $httpRequest->get('ids');

        $ids = [];
        foreach ($rawIds as $rawId) {
            $ids[] = (int) $rawId;
        }

        $request = new ReportRequest($ids);
        $response = ($this->reportUseCase)($request);


        return response()->json(['fdd' => 'd']);
    }
}
