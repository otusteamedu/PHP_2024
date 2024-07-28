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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:report:finance:send', description: 'Sending finance report')]
class SendFinanceReportCommand extends Command
{
    private QueueInterface $queue;
    private SendFinanceReportQueueHandler $handler;
    public function __construct(QueueInterface $queue, SendFinanceReportQueueHandler $handler)
    {
        parent::__construct();
        $this->queue = $queue;
        $this->handler = $handler;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $handler = $this->handler;
        $this->queue->pull(
            SendFinanceReportQueueMessage::QUEUE_NAME,
            static function (AMQPMessage $msg) use ($handler): void {
                $data = json_decode($msg->getBody(), true);
                $handler(
                    new SendFinanceReportQueueMessage($data['email'], $data['content'])
                );
            }
        );
        return 0;
    }
}
