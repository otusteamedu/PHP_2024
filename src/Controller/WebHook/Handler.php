<?php

namespace App\Controller\WebHook;

use App\Application\BotManager\BotParameterEnum;
use App\Application\BotManager\Config;
use App\Domain\DTO\Bus\ChatUpdateDTO;
use App\Domain\Service\AsyncBusService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Telegram\Bot\Api as TelegramAPi;
use Telegram\Bot\BotsManager;

class Handler
{
    private readonly TelegramAPi $telegramApi;

    public function __construct(
        private readonly ParameterBagInterface   $parameterBag,
        private readonly AsyncBusService         $asyncBusService,
    ) {
        $config = (new Config())->getConfig($this->parameterBag);
        $this->telegramApi = (new BotsManager($config))->bot(BotParameterEnum::STB->value);
    }

    public function handleUpdate(): bool
    {
        $this->telegramApi->commandsHandler(true);

        $update = $this->telegramApi->getWebhookUpdate();

        return $this->asyncBusService->handleChatUpdateByAsyncBus(
            new ChatUpdateDTO(
                json_encode(['data' => $update])
            )
        );
    }
}
