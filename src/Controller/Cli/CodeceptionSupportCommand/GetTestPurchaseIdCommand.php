<?php

namespace App\Controller\Cli\CodeceptionSupportCommand;

use App\Controller\Cli\CodeceptionSupportCommand\CodeceptionSupportCommandEnum\CodeceptionSupportCommandEnum;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: self::COMMAND_NAME, description: 'Find and return id of test purchases ', hidden: true)]
class GetTestPurchaseIdCommand extends AbstractCodeceptionSupportCommand
{
    public const COMMAND_NAME = CodeceptionSupportCommandEnum::GetTestPurchaseIdCommandName->value;

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->getTestPurchaseId();
        $output->write($result[1]);

        return $result[0];
    }
}
