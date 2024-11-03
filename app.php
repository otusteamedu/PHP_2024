<?php
require 'vendor/autoload.php';

use App\Application\Service\ProductSearchService;
use App\Console\SearchCommand;
use App\Infrastructure\Persistence\ElasticSearchProductRepository;

// Загружаем конфигурацию
$config = require 'config/config.php';

// Инициализируем репозиторий и сервис поиска
$productRepository = new ElasticSearchProductRepository($config['elasticsearch']);
$productSearchService = new ProductSearchService($productRepository);

// Создаем и выполняем команду поиска
$command = new SearchCommand($productSearchService);
$command->execute($argv);
