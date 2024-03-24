<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$elasticService = new \hw14\ElasticService();
echo $elasticService->testConnection();
