<?php

declare(strict_types=1);

namespace Orlov\Otus\Consumer;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Orlov\Otus\Connection\ConnectionInterface;
use Orlov\Otus\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;

class RabbitMqConsumer
{
    private AMQPChannel|AbstractChannel $channel;
    private string $queue;

    public function __construct(
        private readonly ConnectionInterface $connect,
        private readonly OutputInterface $output
    ) {
        $this->channel = $this->connect->getClient();
        $this->queue = $_ENV['QUEUE'];
    }

    public function run(): void
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            [$this, 'consumeHandler']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->close();
    }

    public function consumeHandler(AMQPMessage $message): void
    {
        $this->output->writeln('<info>[x] ' . $message->body . '</info>');
        (new Mailer($message->body))->send();
    }

    private function close(): void
    {
        $this->channel->close();
        $this->connect->close();
    }
}
