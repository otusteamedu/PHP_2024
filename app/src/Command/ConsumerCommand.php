<?php

declare(strict_types=1);

namespace Orlov\Otus\Command;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use Orlov\Otus\Connection\ConnectionInterface;
use Orlov\Otus\Consumer\RabbitMqConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    private string $queue;
    private AMQPChannel|AbstractChannel $channel;

    public function __construct(private readonly ConnectionInterface $connect)
    {
        parent::__construct();
        $this->channel = $this->connect->getClient();
        $this->queue = $_ENV['QUEUE'];
    }

    protected function configure(): void
    {
        $this->setName('rabbitmq:consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        (new RabbitMqConsumer($this->connect, $output))->run();

        return Command::SUCCESS;
    }
}
