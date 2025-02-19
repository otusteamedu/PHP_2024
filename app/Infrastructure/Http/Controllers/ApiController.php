<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use App\Application\UseCase\GetNewsList\GetNewsListUseCase;
use App\Application\UseCase\GetNewsReport\GetNewsReportRequest;
use App\Application\UseCase\GetNewsReport\GetNewsReportUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param GetNewsListUseCase $getNewsListUseCase
     * @param AddNewsUseCase $addNewsUseCase
     * @param GetNewsReportUseCase $getNewsReportUseCase
     */
    public function __construct(
        public readonly GetNewsListUseCase $getNewsListUseCase,
        public readonly AddNewsUseCase $addNewsUseCase,
        public readonly GetNewsReportUseCase $getNewsReportUseCase,
    ) {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $newsList = ($this->getNewsListUseCase)();

        return response()->json(
            array_map(
                static fn($item) => $item->toArray(),
                $newsList->newsList
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addNews(Request $request): JsonResponse
    {
        $addNewsRequest = new AddNewsRequest($request->get('url'));

        return response()->json(($this->addNewsUseCase)($addNewsRequest));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function summary(Request $request): JsonResponse
    {
        $ids = $request->get('ids');
        $getNewsReportRequest = new GetNewsReportRequest($ids);

        return response()->json([
           'summary_link' => ($this->getNewsReportUseCase)($getNewsReportRequest),
        ]);
    }
}
