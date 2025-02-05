<?php

namespace App\Application\BotCommandHandler;

use App\Application\UseCase\GetCheckList\GetCheckListUseCase;
use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\UseCase\GetShoppingList\GetShoppingListUseCase;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Telegram\Bot\Objects\Update;

#[WithMonologChannel('bot_command')]
class CommandHandler
{
    public function __construct(
        private readonly GetCheckListUseCase    $getCheckListUseCase,
        private readonly GetShoppingListUseCase $getShoppingListUseCase,
        private readonly LoggerInterface        $logger,
    ) {
    }

    public function handleCommand(Update $update): void
    {
        $this->botCommandLogger($update);

        match (BotCommandEnum::tryFrom($this->getCommand($update))) {
            BotCommandEnum::BotCommandCheckList => ($this->getCheckListUseCase)($update),
            BotCommandEnum::BotCommandShopping  => ($this->getShoppingListUseCase)($update),
        };
    }

    private function getCommand(Update $update): string
    {
        if ($update->message->chat->id === $update->message->from->id) {
            $commandWithSlash =  $update->message->text;
            var_dump($this->removeSlash($commandWithSlash));

            return $this->removeSlash($commandWithSlash);
        }

        $commandSeparatorIndex = stripos($update->message->text, BotCommandEnum::CommandSeparator->value);
        $commandWithSlash = substr($update->message->text, 0, $commandSeparatorIndex);

        return $this->removeSlash($commandWithSlash);
    }

    private function removeSlash(string $string): string
    {
        return substr($string, 1);
    }

    private function botCommandLogger(Update $update): void
    {
        $this->logger->info(
            'commandName:'        . $this->getCommand($update)
            . '; chatId:'         . $update->message->chat->id
            . '; telegramUserId:' . $update->message->from->id
            . '; firstName:'      . $update->message->from->firstName
            . '; userName:'       . $update->message->from->username
            . '; isBot:'          . $update->message->from->isBot
        );
    }
}
