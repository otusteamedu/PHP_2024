<?php

declare(strict_types=1);

namespace App\Command;

use App\Queue\Handler\MakeFinanceReportQueueHandler;
use App\Queue\Handler\SendFinanceReportQueueHandler;
use App\Queue\Message\MakeFinanceReportQueueMessage;
use App\Queue\Message\SendFinanceReportQueueMessage;
use App\Queue\QueueInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:queue:messages', description: 'Get queue messages')]
class GetQueueMessagesCommand extends Command
{
    private QueueInterface $queue;
    public function __construct(QueueInterface $queue)
    {
        parent::__construct();
        $this->queue = $queue;
    }

    protected function configure(): void
    {
        $this->addArgument('queue', InputArgument::REQUIRED, 'Queue name');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = $input->getArgument('queue');
        if (empty($queue)) {
            echo "Queue name is required\n";
            return 1;
        }

        echo "Queue list:\n";
        foreach ($this->queue->getMessages($queue) as $msg) {
            echo "Message: " . json_encode($msg) . "\n";
        }

        return 0;
    }
}
