<?php

declare(strict_types=1);

namespace Viking311\Books\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Viking311\Books\Search\Client;

class SearchCommand
{
    private Client $searchClient;

    /**
     * @param Client $searchClient
     */
    public function __construct(Client $searchClient)
    {
        $this->searchClient = $searchClient;
    }

    /**
     * @param array $searchOptions
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function run(array $searchOptions): void
    {
        $result = $this->searchClient->search($searchOptions);
        $this->render($result);
    }

    /**
     * @param array $result
     * @return void
     */
    private function render(array $result): void
    {
        if (empty($result)) {
            fwrite(STDOUT, 'Ничего не найденно' . PHP_EOL) ;
            return;
        }

        fwrite(STDOUT, '|Артикул|Название|Цена|Наличие|' . PHP_EOL) ;
        foreach ($result as $item) {
            $content = '|' . $item['_source']['sku'] . '|'
                . $item['_source']['title'] . '|'
                . $item['_source']['price'] . '|';
            $stock = '';
            foreach ($item['_source']['stock'] as $stockItem) {
                $stock .= $stockItem['shop'] . ':' . $stockItem['stock'] . "шт.;";
            }
            $content .= $stock . '|';
            fwrite(STDOUT, $content . PHP_EOL);
        }
    }
}
