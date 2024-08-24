<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\Report\ReportRequest;
use App\Application\UseCase\Report\ReportUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController
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
            $content = view('report', ['newsList' => $response->news]);
            $fileName = uniqid() . '.html';
            Storage::put('public/' . $fileName, $content);
        } catch (\Exception) {
            response('Internal server  error', 500);
        }

        return response()->json([
            'reportUrl' => asset('storage/' . $fileName),
        ]);
    }
}
