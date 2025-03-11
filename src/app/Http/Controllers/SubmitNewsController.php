<?php

namespace App\Http\Controllers;

use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsResponse;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use App\Http\Requests\SubmitNewsHttpRequest;
use Illuminate\Http\Response;

class SubmitNewsController extends Controller
{
    public function __invoke(SubmitNewsHttpRequest $httpRequest, SubmitNewsUseCase $useCase): \Illuminate\Http\JsonResponse
    {
        $request = new SubmitNewsRequest($httpRequest->url);
        /** @var SubmitNewsResponse $response */
        $response = ($useCase)($request);

        return response()->json(['id' => $response->id], Response::HTTP_CREATED);

    }
}
