<?php

namespace Hinoho\Battleship\Application\SenderUseCase;

use Hinoho\Battleship\Domain\RepositoryInterface\StorageInterface;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class StartUseCase
{

    public function __construct(
        private StorageInterface $storage
    ) {
    }

    public function run()
    {
        $bot_api_key  = 'your:bot_api_key';
        $bot_username = 'username_bot';
        $hook_url     = 'https://your-domain/path/to/hook.php';
        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Set webhook
            $result = $telegram->setWebhook($hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
            // echo $e->getMessage();
        }


    }
}