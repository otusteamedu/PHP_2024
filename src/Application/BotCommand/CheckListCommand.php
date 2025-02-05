<?php

namespace App\Application\BotCommand;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use Telegram\Bot\Commands\Command;

class CheckListCommand extends Command
{
    protected string $name        = BotCommandEnum::BotCommandCheckList->value;
    protected string $description = BotCommandEnum::BotCommandCheckListDescription->value;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function handle()
    {
        $this->replyWithMessage([
            'parse_mode' => BotCommandEnum::ParseModeDefault->value,
            'text' => BotCommandEnum::RequestIsProcessing->value,
        ]);
    }
}
