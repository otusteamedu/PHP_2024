<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\MakeFinanceReportMessage;
use App\Message\SendFinanceReportMessage;
use App\Report\FinanceReportMaker;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class MakeFinanceReportHandler
{
    public function __construct(private FinanceReportMaker $maker, private MessageBusInterface $bus)
    {
    }

    public function __invoke(MakeFinanceReportMessage $message): void
    {
        $content = $this->maker->make($message->from, $message->to);
        $this->bus->dispatch(new SendFinanceReportMessage($message->email, $content));
    }
}
