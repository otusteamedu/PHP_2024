<?php
require 'vendor/autoload.php';

use App\Application\Service\ProductSearchService;
use App\Console\SearchCommand;
use App\Infrastructure\Persistence\ElasticSearchProductRepository;
use App\Infrastructure\Persistence\AnotherDatabaseProductRepository;

// Загружаем конфигурацию
$config = require 'config/config.php';

// Выбираем репозиторий на основе конфигурации
$productRepository = null;

if ($config['repository'] === 'elastic') {
    $productRepository = new ElasticSearchProductRepository($config['elasticsearch']);
} elseif ($config['repository'] === 'another_db') {
    $productRepository = new AnotherDatabaseProductRepository();
}

$productSearchService = new ProductSearchService($productRepository);
$command = new SearchCommand($productSearchService);
$command->execute($argv);
