<?php

declare(strict_types=1);

namespace App\Queue\Handler;

use App\Queue\Message\MakeFinanceReportQueueMessage;
use App\Queue\Message\SendFinanceReportQueueMessage;
use App\Queue\QueueInterface;
use App\Report\FinanceReportMaker;

readonly class MakeFinanceReportQueueHandler
{
    public function __construct(private FinanceReportMaker $maker, private QueueInterface $queue)
    {
    }

    public function __invoke(MakeFinanceReportQueueMessage $message): void
    {
        $content = $this->maker->make($message->from, $message->to);
        $this->queue->push(new SendFinanceReportQueueMessage($message->email, $content));
    }
}
