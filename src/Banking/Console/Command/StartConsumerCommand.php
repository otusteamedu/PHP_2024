<?php

declare(strict_types=1);

namespace App\Banking\Console\Command;

use App\Banking\Queue\ConnectionProvider;
use App\Banking\Queue\ConsumerInterface;
use App\Banking\Queue\MessageProcessFlag;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

final class StartConsumerCommand extends Command
{
    private const string CONSUMER_NAME = 'name';

    public function __construct(
        private readonly Container $container,
        private readonly ConnectionProvider $connectionProvider,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('queue:consumer:start')
            ->setDescription('Starts the consumer')
            ->addArgument(
                self::CONSUMER_NAME,
                InputArgument::REQUIRED,
                'The name of the queue to consumer'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consumerName = sprintf('queue.consumer.%s', $input->getArgument(self::CONSUMER_NAME));

        try {
            /** @var ConsumerInterface $consumer */
            $consumer = $this->container->get($consumerName);
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return self::FAILURE;
        }

        $channel = $this->connectionProvider->getChannel();

        $this->connectionProvider->setupChannel(
            $channel,
            $consumer->getQueueName(),
            $consumer->getExchangeName()
        );

        $output->writeln(sprintf('<info>Consumer [%s] started</info>', $consumerName));

        $channel->basic_consume(
            queue: $consumer->getQueueName(),
            callback: function (AMQPMessage $message) use ($output, $consumer): void {
                $text = sprintf('<info>Consumed message: %s</info>', $message->getBody());

                $output->writeln($text);

                $messageProcessFlag = $consumer->consume($message);

                match ($messageProcessFlag) {
                    MessageProcessFlag::ACKNOWLEDGED => $message->ack(),
                    MessageProcessFlag::REJECTED => $message->reject(false),
                    MessageProcessFlag::NEED_REQUEUE => $message->reject(),
                };
            }
        );

        register_shutdown_function([$this->connectionProvider, 'closeConnection']);

        $channel->consume();

        return self::SUCCESS;
    }
}
