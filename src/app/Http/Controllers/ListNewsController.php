<?php

namespace App\Http\Controllers;

use App\Application\UseCase\ListNews\ListNewsResponse;
use App\Application\UseCase\ListNews\ListNewsUseCase;
use App\Http\Resources\NewsResource;

class ListNewsController extends Controller
{
    public function __invoke(ListNewsUseCase $useCase): \Illuminate\Http\JsonResponse
    {
        /** @var ListNewsResponse $response */
        $response = ($useCase)();

        return response()->json(['news' => NewsResource::collection($response->news)]);

    }
}
