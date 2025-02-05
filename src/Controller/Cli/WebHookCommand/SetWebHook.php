<?php

namespace App\Controller\Cli\WebHookCommand;

use App\Application\BotManager\BotParameterEnum;
use App\Application\BotManager\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Telegram\Bot\Api as TelegramAPi;
use Telegram\Bot\BotsManager;

#[AsCommand(name: self::COMMAND_NAME, description: 'Set web-hook', hidden: true)]
class SetWebHook extends Command
{
    public const COMMAND_NAME = 'web-hook:set';
    private TelegramAPi $telegramApi;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
        $config = (new Config())->getConfig($this->parameterBag);
        $this->telegramApi = (new BotsManager($config))->bot(BotParameterEnum::STB->value);
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->telegramApi->setWebhook(
            ['url' => $this->parameterBag->get('site_url') . $this->parameterBag->get('shopping_together_bot_web_hook_rout')]
        );

        $output->write('result code: ' . ($response ? self::SUCCESS : self::FAILURE) . PHP_EOL);

        return $response ? self::SUCCESS : self::FAILURE;
    }
}
