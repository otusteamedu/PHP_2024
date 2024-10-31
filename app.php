<?php
require 'vendor/autoload.php';

use App\Data\ElasticSearchClient;
use App\Data\ProductRepository;
use App\Console\SearchCommand;

$config = require 'config/config.php';
$client = new ElasticSearchClient($config['elasticsearch']);
$repository = new ProductRepository($client);

// Если нужно инициализировать данные
$repository->initializeData('data/books.json');

$command = new SearchCommand($repository);
$command->execute($argv);
