<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Actions\CreateNewsActionInterface;
use App\Application\Actions\ExportNewsActionInterface;
use App\Application\Requests\CreateNewsRequest;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Infrastructure\Requests\ExportNewsRequest;
use App\Infrastructure\Requests\StoreNewsRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function index(NewsRepositoryInterface $newsRepository): JsonResponse
    {
        $newsEntities = $newsRepository->all();

        return response()->json($newsEntities);
    }

    public function store(StoreNewsRequest $request, CreateNewsActionInterface $action): JsonResponse
    {
        $createNewsRequest = new CreateNewsRequest($request->validated('url'));

        try {
            $createNewsResponse = call_user_func($action, $createNewsRequest);
        } catch (Exception $exception) {
            // todo: log

            return response()->withException($exception)->json(status: 400);
        }

        return response()->json(get_object_vars($createNewsResponse));
    }

    public function export(
        ExportNewsRequest $request,
        ExportNewsActionInterface $action,
        NewsRepositoryInterface $newsRepository
    ): JsonResponse {
        $newsEntities = $newsRepository->findMultipleById($request->validated('ids'));

        try {
            $exportNewsResponse = call_user_func($action, $newsEntities);
        } catch (Exception $exception) {
            // todo: log

            return response()->withException($exception)->json(status: 400);
        }

        return response()->json(get_object_vars($exportNewsResponse));
    }
}
