<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Console\Consumer\Application;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\Console\Consumer\Service\MessageConsume\MessageConsumeService;
use AlexanderGladkov\Broker\Factory\RabbitMQConsumerFactory;
use AlexanderGladkov\Broker\Service\Mail\GmailMailService;

class Application
{
    public function run(): void
    {
        $config = new Config();
        $mailService = new GmailMailService($config->getGMailTransportDsn());
        $consumer = (new RabbitMQConsumerFactory())->create($config);
        (new MessageConsumeService($consumer, $mailService))->startConsume();
    }
}
