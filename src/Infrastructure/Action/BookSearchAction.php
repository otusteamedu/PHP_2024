<?php

declare(strict_types=1);

namespace App\Infrastructure\Action;

use App\Application\UseCase\Request\SearchBookRequest;
use App\Application\UseCase\SearchBookUseCase;
use App\Infrastructure\Main\Console\Application;
use App\Infrastructure\Repository\ElasticsearchBookRepository;
use App\Infrastructure\View\Table;

class BookSearchAction
{
    public function getAvailableOptions() :array
    {
        return [
            'title:',
            'category:',
            'minPrice:',
            'maxPrice:',
            'shopName:',
            'minStock:'
        ];
    }

    public function exec($options)
    {
        $searchBookRequest = new SearchBookRequest(
        $options['title'] ?? null,
        $options['category'] ?? null,
        isset($options['minPrice']) ? (int)$options['minPrice'] : null,
        isset($options['maxPrice']) ? (int)$options['maxPrice'] : null,
        $options['shopName'] ?? null,
        isset($options['minStock']) ? (int)$options['minStock'] : null
        );

        $elasticsearchHost = Application::getInstance()->getParam('elasticsearchHost');
        $elasticsearchIndex = Application::getInstance()->getParam('elasticsearchIndex');

        $bookRepository = new ElasticsearchBookRepository(
            $elasticsearchHost,
            $elasticsearchIndex
        );
        $useCase = new SearchBookUseCase($bookRepository);
        $response = $useCase->execute($searchBookRequest);
        $view = new Table($response->bookCollection);
        return $view->render();
    }
}
