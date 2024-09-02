<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Actions\CreateNewsAction;
use App\Application\Actions\ExportNewsAction;
use App\Application\Requests\CreateNewsRequest;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Infrastructure\Requests\ExportNewsRequest;
use App\Infrastructure\Requests\StoreNewsRequest;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function index(NewsRepositoryInterface $newsRepository): JsonResponse
    {
        $newsEntities = $newsRepository->all();

        return response()->json($newsEntities);
    }

    public function store(StoreNewsRequest $request, CreateNewsAction $action): JsonResponse
    {
        $createNewsRequest = new CreateNewsRequest($request->validated('url'));

        $createNewsResponse = call_user_func($action, $createNewsRequest);

        return response()->json([
            'message' => 'Article created successful.',
            'data' => get_object_vars($createNewsResponse),
        ]);
    }

    public function export(
        ExportNewsRequest $request,
        ExportNewsAction $action,
        NewsRepositoryInterface $newsRepository
    ): JsonResponse {
        $newsEntities = $newsRepository->findMultipleById($request->validated('ids'));

        $exportNewsResponse = call_user_func($action, $newsEntities);

        return response()->json([
            'message' => 'Export successfully prepared.',
            'data' => get_object_vars($exportNewsResponse),
        ]);
    }
}
