<?php

namespace App\Controller\Cli;

use App\Application\BotManager\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use GuzzleHttp\Client;

#[AsCommand(name: self::COMMAND_NAME, description: 'Set my bot commands by Telegram API', hidden: true)]
class SetMyCommandsCommand extends Command
{
    public const COMMAND_NAME = 'my:commands:set';
    private readonly array $config;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
        $this->config = (new Config())->getConfig($this->parameterBag);
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response =  $this->send();
        $output->write('response: ' . $response);

        return $response ? self::SUCCESS : self::FAILURE;
    }

    private function send(): string
    {
        $client = new Client();

        $token = $this->config['bots']['shopping-together-bot']['token'];

        $uri = 'https://api.telegram.org/bot' . $token . '/setMyCommands?commands=' .  $this->getCommand() ;

        $response = $client->request('GET', $uri);

        return $response->getBody() . PHP_EOL;
    }

    private function getCommand(): string
    {
        $classCommandArray = $this->config['bots']['shopping-together-bot']['commands'];

        $botCommandArray = [];

        foreach ($classCommandArray as $class) {
            $botCommandArray[] = [
                "command" => (new $class)->getName(),
                "description" => (new $class)->getDescription(),
            ];
        }

        return  json_encode($botCommandArray);
    }
}
