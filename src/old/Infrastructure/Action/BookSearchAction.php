<?php

declare(strict_types=1);

namespace App\old\Infrastructure\Action;

use App\old\Application\UseCase\Request\SearchBookRequest;
use App\old\Application\UseCase\SearchBookUseCase;
use App\old\Infrastructure\Main\Console\Application;
use App\old\Infrastructure\Repository\BookDataMapper;
use App\old\Infrastructure\Repository\ElasticsearchBookQueryBuilder;
use App\old\Infrastructure\Repository\ElasticsearchBookRepository;
use App\old\Infrastructure\View\Table;
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
