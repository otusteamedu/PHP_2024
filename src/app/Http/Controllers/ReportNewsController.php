<?php

namespace App\Http\Controllers;

use App\Application\UseCase\ReportNews\ReportNewsRequest;
use App\Application\UseCase\ReportNews\ReportNewsUseCase;
use App\Http\Requests\ReportNewsHttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ReportNewsController extends Controller
{
    public function __invoke(ReportNewsHttpRequest $httpRequest, ReportNewsUseCase $useCase): \Illuminate\Http\JsonResponse
    {
        $request = new ReportNewsRequest($httpRequest->ids);
        $response = ($useCase)($request);

        return response()->json(['file_url' => $response->fileUrl], Response::HTTP_CREATED);

    }
}
