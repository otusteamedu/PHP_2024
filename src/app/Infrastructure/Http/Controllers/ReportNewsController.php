<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\ReportNews\ReportNewsRequest;
use App\Application\UseCase\ReportNews\ReportNewsUseCase;
use App\Infrastructure\Http\Requests\ReportNewsHttpRequest;
use Illuminate\Http\Response;

class ReportNewsController extends Controller
{
    public function __invoke(ReportNewsHttpRequest $httpRequest, ReportNewsUseCase $useCase): \Illuminate\Http\JsonResponse
    {
        $request = new ReportNewsRequest($httpRequest->ids);
        $response = ($useCase)($request);

        return response()->json(['file_url' => $response->fileUrl], Response::HTTP_CREATED);

    }
}
