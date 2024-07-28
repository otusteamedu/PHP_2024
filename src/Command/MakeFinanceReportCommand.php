<?php

declare(strict_types=1);

namespace App\Command;

use App\Queue\Handler\MakeFinanceReportQueueHandler;
use App\Queue\Message\MakeFinanceReportQueueMessage;
use App\Queue\QueueInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:report:finance:make', description: 'Making finance report')]
class MakeFinanceReportCommand extends Command
{
    private QueueInterface $queue;
    private MakeFinanceReportQueueHandler $handler;
    public function __construct(QueueInterface $queue, MakeFinanceReportQueueHandler $handler)
    {
        parent::__construct();
        $this->queue = $queue;
        $this->handler = $handler;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $handler = $this->handler;
        $this->queue->pull(
            MakeFinanceReportQueueMessage::QUEUE_NAME,
            static function (AMQPMessage $msg) use ($handler): void {
                $data = json_decode($msg->getBody(), true);
                $handler(
                    new MakeFinanceReportQueueMessage($data['email'], new \DateTime($data['from']), new \DateTime($data['to']))
                );
            }
        );
        return 0;
    }
}
