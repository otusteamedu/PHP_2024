<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Controller;

use Illuminate\Routing\Controller;
use Module\News\Application\UseCase\Create\CreateNewsUseCase;
use Module\News\Application\UseCase\CreateReport\CreateReportUseCase;
use Module\News\Application\UseCase\GetList\GetListUseCase;
use Module\News\Application\UseCase\GetList\ListItem;
use Module\News\Infrastructure\FormRequest\CreateNewsFormRequest;
use Module\News\Infrastructure\FormRequest\CreateReportFormRequest;

use function array_map;

final class NewsController extends Controller
{
    public function __construct(
        private readonly CreateNewsUseCase $createNews,
        private readonly GetListUseCase $getList,
        private readonly CreateReportUseCase $createReport,
    ) {
    }

    public function create(CreateNewsFormRequest $request): array
    {
        $response = ($this->createNews)($request->toUseCaseRequest());

        return ['id' => $response->id];
    }

    public function getList(): array
    {
        $response = ($this->getList)();

        $items = array_map(static function (ListItem $item): array {
            return [
                'uuid' => $item->uuid,
                'url' => $item->url,
                'title' => $item->title,
                'date' => $item->date->format('Y-m-d H:i'),
            ];
        }, $response->items);

        return ['list' => $items];
    }

    public function createReport(CreateReportFormRequest $request): array
    {
        $response = ($this->createReport)($request->toUseCaseRequest());

        return ['link' => $response->link];
    }
}
