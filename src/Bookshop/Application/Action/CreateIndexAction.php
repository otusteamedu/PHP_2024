<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application\Action;

use AlexanderGladkov\Bookshop\Index\Index;

class CreateIndexAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $index = new Index($this->elasticsearchClient);
        $index->deleteIfExists();
        $index->create();
        $indexData = file_get_contents($this->config->getIndexDataFilePath());
        $index->fillByString($indexData);
        return new Response('Success!' . PHP_EOL);
    }
}
