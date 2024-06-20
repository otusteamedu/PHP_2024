<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Orlov\Otus\Command\ConsumerCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

try {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../.env');

    $application = new Application();
    $application->add(new ConsumerCommand(new $_ENV['BROKER_CONNECT']()));

    $application->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}
