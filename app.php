<?php

declare(strict_types=1);

use App\Application\UseCase\SearchProductsUseCase;
use App\Infrastructure\Cli\Command\LoadDumpCommand;
use App\Infrastructure\Cli\Command\SearchCommand;
use App\Infrastructure\Cli\Parser\ConditionParser;
use App\Infrastructure\Cli\Repository\ElasticProductRepository;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application();

$elasticClient = \Elastic\Elasticsearch\ClientBuilder::create()
    ->setSSLVerification(false)
    ->setHosts([getenv('ES_HOST') . ':' . getenv('ES_PORT')])
    ->build();

$app->add(new SearchCommand(new SearchProductsUseCase(new ConditionParser(), new ElasticProductRepository($elasticClient))));
$app->add(new LoadDumpCommand($elasticClient));

$app->run();
