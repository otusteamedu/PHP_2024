<?php

namespace App\Application\BotCommand;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use Telegram\Bot\Commands\Command;

class DevCommand extends Command
{
    protected string $name        = BotCommandEnum::BotCommandDev->value;
    protected string $description = BotCommandEnum::BotCommandDevDescription->value;

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
        $response = "*Уважаемый пользователь!*" . PHP_EOL;

        $response .= 'Если вы хотите поделиться своими впечатлениями о боте, высказать пожелания или даже конструктивную критику, то можете написать разработчику этого бота - @JohnMontigomo' . PHP_EOL;

        $this->replyWithMessage([
            'parse_mode' => BotCommandEnum::ParseModeDefault->value,
            'text'       => $response
        ]);
    }
}
