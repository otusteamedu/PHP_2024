<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\ListNews\ListNewsResponse;
use App\Application\UseCase\ListNews\ListNewsUseCase;

class ListNewsController extends Controller
{
    public function __invoke(ListNewsUseCase $useCase): \Illuminate\Http\JsonResponse
    {
        /** @var ListNewsResponse[] $response */
        $response = ($useCase)();

        return response()->json($response);
    }
}
