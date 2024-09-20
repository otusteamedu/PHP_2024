<?php

declare(strict_types=1);

namespace App\UI\Command;

use App\Application\UseCase\CreateMealUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-meal',
    description: 'Создание блюда (бургер, хот-дог или сэндвич)'
)]
class CreateMealConsoleCommand extends Command
{
    public function __construct(private readonly CreateMealUseCase $createMealService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('type', InputArgument::REQUIRED, 'Тип блюда (burger, hotdog, sandwich)')
            ->addOption('ingredients', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Addings (lettuce, onion, pepper)', []);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $mealType = $input->getArgument('type');
        $ingredients = $input->getOption('ingredients');

        if (!in_array($mealType, ['burger', 'hotdog', 'sandwich'])) {
            $output->writeln('<error>Unknown meal. Allowed meals: burger, hotdog, sandwich</error>');
            return Command::FAILURE;
        }

        try {
            ($this->createMealService)($mealType, $ingredients);
            $output->writeln('<info>Meal is prepared! Enjoy</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>Error: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
