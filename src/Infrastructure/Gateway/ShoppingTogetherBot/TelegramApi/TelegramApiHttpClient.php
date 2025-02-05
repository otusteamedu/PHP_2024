<?php

namespace App\Infrastructure\Gateway\ShoppingTogetherBot\TelegramApi;

use App\Application\BotManager\BotParameterEnum;
use App\Application\BotManager\Config;
use App\Application\Gateway\BotMessageDTO\EditBotMessageDTO;
use App\Application\Gateway\BotMessageDTO\SendBotMessageDTO;
use App\Application\Gateway\TelegramApi\TelegramApiHttpClientInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Telegram\Bot\Api as TelegramAPi;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

#[WithMonologChannel('bot_message')]
class TelegramApiHttpClient implements TelegramApiHttpClientInterface
{
    private TelegramAPi $telegramApi;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly LoggerInterface $logger,
    ) {
        $config = (new Config())->getConfig($this->parameterBag);
        $this->telegramApi = (new BotsManager($config))->bot(BotParameterEnum::STB->value);
    }

    public function sendBotMessage(SendBotMessageDTO $sendBotMessageDTO): void
    {
        $message = [
            'chat_id'      => $sendBotMessageDTO->chatId,
            'parse_mode'   => $sendBotMessageDTO->parseMode,
            'text'         => $sendBotMessageDTO->text,
            'reply_markup' => $sendBotMessageDTO->replyMarkup
        ];

        $details = 'send';
        try {
           $this->telegramApi->sendMessage($message);
        } catch (TelegramSDKException $e) {
            $details = $e->getMessage();
        } finally {
            $this->logger->info($sendBotMessageDTO->useCase . ':' . $details . ':' .json_encode($message, JSON_UNESCAPED_UNICODE));
        }
    }

    public function editBotMessage(EditBotMessageDTO $editBotMessageDTO): void
    {
        $message = [
            'chat_id'      => $editBotMessageDTO->chatId,
            'message_id'   => $editBotMessageDTO->messageId,
            'parse_mode'   => $editBotMessageDTO->parseMode,
            'text'         => $editBotMessageDTO->text,
            'reply_markup' => $editBotMessageDTO->replyMarkup
        ];

        $details = 'send';
        try {
            $this->telegramApi->editMessageText($message);
        } catch (TelegramSDKException $e) {
            $details = $e->getMessage();
        } finally {
            $this->logger->info($editBotMessageDTO->useCase . ':' . $details . ':' .json_encode($message, JSON_UNESCAPED_UNICODE));
        }
    }
}
