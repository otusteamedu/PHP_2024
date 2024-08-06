<?php

namespace App\Actions;

use App\Templates\DefaultTemplate;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class SearchAction
{
    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(string $title, int $price): void
    {
        $result = (new DefaultTemplate($title, $price))->search();

        $this->print($result);
    }

    private function print(array $result): void
    {
        $hits = $result['hits']['hits'];

        $headers = ["SKU", "Title", "Category", "Price", "Total Stock"];

        $columnWidths = array_map('strlen', $headers);
        foreach ($hits as $hit) {
            $sku = $hit['_source']['sku'];
            $title = $hit['_source']['title'];
            $category = $hit['_source']['category'];
            $price = $hit['_source']['price'];
            $totalStock = array_sum(array_column($hit['_source']['stock'], 'stock'));

            $columnWidths[0] = max($columnWidths[0], strlen($sku));
            $columnWidths[1] = max($columnWidths[1], strlen($title));
            $columnWidths[2] = max($columnWidths[2], strlen($category));
            $columnWidths[3] = max($columnWidths[3], strlen((string)$price));
            $columnWidths[4] = max($columnWidths[4], strlen((string)$totalStock));
        }

        echo str_pad($headers[0], $columnWidths[0]) . " | " .
            str_pad($headers[1], $columnWidths[1]) . " | " .
            str_pad($headers[2], $columnWidths[2]) . " | " .
            str_pad($headers[3], $columnWidths[3]) . " | " .
            str_pad($headers[4], $columnWidths[4]) . PHP_EOL;
        echo str_repeat("-", array_sum($columnWidths) + 3 * count($headers) + 1) . PHP_EOL;

        foreach ($hits as $hit) {
            $sku = $hit['_source']['sku'];
            $title = $hit['_source']['title'];
            $category = $hit['_source']['category'];
            $price = $hit['_source']['price'];
            $totalStock = array_sum(array_column($hit['_source']['stock'], 'stock'));

            echo str_pad($sku, $columnWidths[0]) . " | " .
                str_pad($title, $columnWidths[1]) . " | " .
                str_pad($category, $columnWidths[2]) . " | " .
                str_pad((string)$price, $columnWidths[3]) . " | " .
                str_pad((string)$totalStock, $columnWidths[4]) . PHP_EOL;
        }
    }
}
