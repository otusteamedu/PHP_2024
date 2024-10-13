<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\Report\ReportRequest;
use App\Application\UseCase\Report\ReportUseCase;
use Exception;
use Illuminate\Http\Request;

readonly class ReportController
{
    public function __construct(
        private ReportUseCase $reportUseCase
    ) {
    }

    public function __invoke(Request $httpRequest)
    {
        $rawIds = $httpRequest->get('ids');

        $ids = [];
        foreach ($rawIds as $rawId) {
            $ids[] = (int) $rawId;
        }
        try {
            $request = new ReportRequest($ids);
            $response = ($this->reportUseCase)($request);
        } catch (Exception) {
            return response('Internal server  error', 500);
        }

        return response()->json($response);
    }
}
