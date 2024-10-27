<?php

namespace VladimirGrinko\ElasticSearch;

use \Elastic\Elasticsearch\{
    Response\Elasticsearch as ResEs
};

class Format
{
    private $arRes;

    public function __construct(ResEs $esBody)
    {
        $this->arRes = $esBody->asArray();
    }

    public function formatOnce(): string
    {
        $resStr = '========' . PHP_EOL;
        $resStr .= $this->formatProduct($this->arRes['_source']);
        return $resStr;
    }

    public function formatList(): string
    {
        $resStr = '========' . PHP_EOL;
        $resStr .= 'Всего найдено товаров: ' . $this->arRes['hits']['total']['value'] . PHP_EOL;
        $resStr .= '========' . PHP_EOL;

        foreach ($this->arRes['hits']['hits'] as $arHit) {
            $resStr .= $this->formatProduct($arHit['_source']);
        }

        return $resStr;
    }

    private function formatProduct(array $product): string
    {
        $resStr = '';
        $resStr .= 'Артикул: ' . $product['sku'] . PHP_EOL;
        $resStr .= 'Название: ' . $product['title'] . PHP_EOL;
        $resStr .= 'Жанр: ' . $product['category'] . PHP_EOL;
        $resStr .= 'Цена: ' . $product['price'] . ' рублей' . PHP_EOL;
        $resStr .= 'Наличие в магазинах: ' . PHP_EOL;
        foreach ($product['stock'] as $store) {
            $resStr .= '   > ' . $store['shop'] . ' - ' . $store['stock'] . PHP_EOL;
        }
        $resStr .= '========' . PHP_EOL;
        return $resStr;
    }

    public function getArray(): array
    {
        return $this->arRes;
    }
}
