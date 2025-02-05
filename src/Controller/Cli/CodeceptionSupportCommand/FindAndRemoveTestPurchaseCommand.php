<?php

namespace App\Controller\Cli\CodeceptionSupportCommand;

use App\Controller\Cli\CodeceptionSupportCommand\CodeceptionSupportCommandEnum\CodeceptionSupportCommandEnum;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: self::COMMAND_NAME, description: 'Find and remove acceptance test purchases', hidden: true)]
class FindAndRemoveTestPurchaseCommand extends AbstractCodeceptionSupportCommand
{
    public const COMMAND_NAME = CodeceptionSupportCommandEnum::FindAndRemoveTestPurchaseCommandName->value;
    private const MESSAGE_SHIFT = CodeceptionSupportCommandEnum::CommandMessageShift->value;

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->checkItemInDB();
        if ($result[0] === self::FAILURE) {
            $output->write(self::MESSAGE_SHIFT . $result[1] . PHP_EOL);

            return $result[0];
        }

        $result = $this->checkPurchaseMarkedAsPurchasedInDB();
        if ($result[0] === self::FAILURE) {
            $output->write(self::MESSAGE_SHIFT . $result[1] . PHP_EOL);

            return $result[0];
        }

        $result = $this->removeItemFromDB();
        $output->write(self::MESSAGE_SHIFT . $result[1] . PHP_EOL);

        return $result[0];
    }
}
