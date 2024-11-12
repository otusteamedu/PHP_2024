<?php

namespace VSukhov\Hw12\App;

use VSukhov\Hw12\Application\Service\ProductSearchService;
use VSukhov\Hw12\Infostructure\Elastic\ElasticSearchService;
use VSukhov\Hw12\Infostructure\Elastic\ProductRepository;
use VSukhov\Hw12\Interface\ProductSearchCommand;

class App
{
    private ProductSearchCommand $command;
    private ElasticSearchService $elasticSearchService;

    public function __construct()
    {
        $this->elasticSearchService = new ElasticSearchService();
        $productRepository = new ProductRepository($this->elasticSearchService);
        $productSearchService = new ProductSearchService($productRepository);

        $this->command = new ProductSearchCommand($productSearchService);
    }

    public function run(array $args): void
    {
        $this->command->execute($args);
    }
}
