<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

$factory = new LowBlow\GreetingLib\GreetingFactory();

echo $factory->generate('Petya');
