<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Udavikhin\UselessFactsApiClient\UselessFactsApiClient;

$client = new UselessFactsApiClient();

$randomFact = json_decode($client->getRandomFact());
echo $randomFact->text . PHP_EOL;
