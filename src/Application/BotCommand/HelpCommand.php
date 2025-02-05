<?php

namespace App\Application\BotCommand;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{
    protected string $name        = BotCommandEnum::BotCommandHelp->value;
    protected string $description = BotCommandEnum::BotCommandHelpDescription->value;

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
        $response = '*Список команд:*' . PHP_EOL;

        $commands = $this->getTelegram()->getCommands();
        foreach ($commands as $name   => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name  , $command->getDescription());
        }

        $this->replyWithMessage([
            'parse_mode' => BotCommandEnum::ParseModeDefault->value,
            'text'       => $response
        ]);
    }
}
