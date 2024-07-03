<?php

declare(strict_types=1);

namespace App\Infrastructure\Action;

use App\Application\UseCase\Request\SearchBookRequest;
use App\Application\UseCase\SearchBookUseCase;
use App\Infrastructure\Main\Console\Application;
use App\Infrastructure\Repository\BookDataMapper;
use App\Infrastructure\Repository\ElasticsearchBookQueryBuilder;
use App\Infrastructure\Repository\ElasticsearchBookRepository;
use App\Infrastructure\View\Table;
use Elastic\Elasticsearch\ClientBuilder;

class BookSearchAction
{
    public function getAvailableOptions(): array
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

        $client = ClientBuilder::create()
            ->setHosts(Application::getInstance()->getParam('elasticsearchHost'))
            ->build();
        $queryBuilder = new ElasticsearchBookQueryBuilder(Application::getInstance()->getParam('elasticsearchIndex'));
        $bookDataMapper = new BookDataMapper();


        $bookRepository = new ElasticsearchBookRepository(
            $client,
            $queryBuilder,
            $bookDataMapper
        );

        $useCase = new SearchBookUseCase($bookRepository);
        $response = $useCase->execute($searchBookRequest);
        $view = new Table($response->bookCollection);
        return $view->render();
    }
}
