<?php

declare(strict_types=1);

use App\Base\Config;
use App\Services\Connector;
use App\Services\Connectors\ElasticConnector;
use App\Services\Connectors\RedisConnector;
use App\Services\Search;

require '../vendor/autoload.php';

$settings = require './config/settings.php';

$config = Config::getInstance();
$config->load($settings);

try {
    $redis = new RedisConnector($config->getConfig('connections.redis'));
    $elastic = new ElasticConnector($config->getConfig('connections.elastic'));
    $connector = new Connector(['redis' => $redis, 'elastic' => $elastic]);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    die();
}

$events = require_once 'data/events.php';

/**
 * REDIS EXAMPLE
 */

foreach ($events as $item) {
    $connector->client('redis')->setKey("event:{$item['id']}", $item);
}

$redisSearch = $connector->client('redis')->search('event:1');
echo $redisSearch->event . PHP_EOL;

/**
 * ELASTIC EXAMPLE
 */
foreach ($events as $item) {
    $connector->client('elastic')->setKey("event:{$item['id']}", $item);
}

$elasticSearch = $connector->client('elastic')->search('event:1');
echo $elasticSearch->event . PHP_EOL;



/**
 * SEARCH REDIS EXAMPLE
 */
echo 'REDIS' . PHP_EOL;

$param1 = readline('Значение1: ');
$param2 = readline('Значение2: ');

$search = new Search($connector->client('redis'));
$result = $search->search(['param1' => $param1, 'param2' => $param2]);

echo 'Приоритет: ' . $result['priority'] . PHP_EOL;
echo 'Событие: ' . $result['event'] . PHP_EOL;


/**
 * SEARCH ELASTIC EXAMPLE
 */
echo 'ELASTIC' . PHP_EOL;

$param1 = readline('Значение1: ');
$param2 = readline('Значение2: ');

$search = new Search($connector->client('elastic'));
$result = $search->search(['param1' => $param1, 'param2' => $param2]);

echo 'Приоритет: ' . $result['priority'] . PHP_EOL;
echo 'Событие: ' . $result['event'] . PHP_EOL;
