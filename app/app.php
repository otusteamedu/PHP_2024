<?php

declare(strict_types=1);

use App\Base\Config;
use App\Enums\LogLevelEnum;
use App\Search\BookSearch;
use App\Services\ElasticConnector;
use App\Services\Logger;
use Elastic\Elasticsearch\Exception\AuthenticationException;

require '../vendor/autoload.php';

$settings = require './config/settings.php';
$env = parse_ini_file(__DIR__ . '/../.env');
$config = new Config($settings, $env);

try {
    $client = new ElasticConnector($config);
} catch (AuthenticationException $e) {
    echo $e->getMessage();
    die();
}

$search = new BookSearch($client);

foreach ($search->fields() as $field => $fieldName) {
    $search->$field = readline($fieldName);
}

try {
    echo $search->search();
} catch (Exception $e) {
    echo $e->getMessage();
    Logger::getInstance()->writeLog(
        LogLevelEnum::ERROR,
        ['type' => 'search-error', 'message' => $e->getMessage()],
        $config->logPath
    );
}
