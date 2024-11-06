<?php

declare(strict_types=1);

use App\Controller\DefaultController;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Подключаемся к Redis
$options = [
    'cluster' => 'redis',
];

$nodes = [
    'tcp://redis1:6379',
    'tcp://redis2:6379',
    'tcp://redis3:6379',
    'tcp://redis4:6379',
    'tcp://redis5:6379',
    'tcp://redis6:6379'
];

$client = new Predis\Client($nodes, $options);

$controller = new DefaultController();
echo json_encode($controller->handleRequest());
