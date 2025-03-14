<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\TextConverter\TextConverterRegistry;
use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use App\Application\UseCase\GetNews\GetNewsRequest;
use App\Application\UseCase\GetNewsList\GetNewsListUseCase;
use App\Application\UseCase\GetNews\GetNewsUseCase;
use App\Infrastructure\Middleware\BlacklistedIpRequestHandler;
use App\Infrastructure\Middleware\LoadLimitRequestHandler;
use App\Infrastructure\Middleware\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param GetNewsListUseCase $getNewsListUseCase
     * @param AddNewsUseCase $addNewsUseCase
     * @param GetNewsUseCase $getNewsUseCase
     */
    public function __construct(
        public readonly GetNewsListUseCase $getNewsListUseCase,
        public readonly AddNewsUseCase     $addNewsUseCase,
        public readonly GetNewsUseCase     $getNewsUseCase,
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // создаем цепочку обработчиков для middleware
        $firstHandler = new LoadLimitRequestHandler();
        $firstHandler
            ->setNext(new BlacklistedIpRequestHandler());

        // создаем middleware и обрабатываем вызов validate
        $middleware = new Middleware($firstHandler);
        try {
            $middleware->validate($request);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        // получаем нужный конвертер текста из реестра по переданному параметру format
        $textConverter = TextConverterRegistry::get($request->get('format'));

        $newsList = ($this->getNewsListUseCase)($textConverter);

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
    public function store(Request $request): JsonResponse
    {
        $addNewsRequest = new AddNewsRequest(
            $request->get('title'),
            $request->get('author'),
            $request->get('category'),
            $request->getContent(),
        );

        return response()->json(($this->addNewsUseCase)($addNewsRequest));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        // создаем цепочку обработчиков для middleware
        $firstHandler = new LoadLimitRequestHandler();
        $firstHandler
            ->setNext(new BlacklistedIpRequestHandler());

        // создаем middleware и обрабатываем вызов validate
        $middleware = new Middleware($firstHandler);
        try {
            $middleware->validate($request);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        $getNewsRequest = new GetNewsRequest($id);

        // получаем нужный конвертер текста из реестра по переданному параметру format
        $textConverter = TextConverterRegistry::get($request->get('format'));

        return response()->json(($this->getNewsUseCase)($getNewsRequest, $textConverter)->news->toArray());
    }
}
