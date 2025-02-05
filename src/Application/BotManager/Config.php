<?php

namespace App\Application\BotManager;

use App\Application\BotCommand\ShoppingCommand;
use App\Application\BotCommand\DevCommand;
use App\Application\BotCommand\HelpCommand;
use App\Application\BotCommand\CheckListCommand;
use App\Application\BotCommand\StartCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Config
{
    public function getConfig(ParameterBagInterface $parameterBag): array
    {
        return
            [
                'bots' => [
                    BotParameterEnum::STB->value => [
                        'token'       => $parameterBag->get('shopping_together_bot_telegram_token'),
                        'webhook_url' => $parameterBag->get('site_url')
                                            . $parameterBag->get('shopping_together_bot_web_hook_rout'),
                        'commands'    => [
                            StartCommand::class,
                            HelpCommand::class,
                            CheckListCommand::class,
                            ShoppingCommand::class,
                            DevCommand::class
                        ],
                    ],
                ],

                'default' => BotParameterEnum::STB->value
            ];
    }
}





