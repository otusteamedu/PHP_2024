<?php

declare(strict_types=1);

namespace App\Infrastructure\Commands;

use App\Application\UseCase\CreateTransaction\CreateTransactionRequest;
use App\Application\UseCase\CreateTransaction\CreateTransactionUseCase;
use App\Domain\Repository\AccountRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(name: 'app:generate-transactions')]
class AddTransactionsCommand extends Command
{
    public function __construct(
        private readonly CreateTransactionUseCase $useCase,
        private AccountRepositoryInterface $accountRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('account', InputArgument::REQUIRED, 'Account ID')
            ->addArgument('number', InputArgument::REQUIRED, 'Number of transactions to generate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {


            $number  =  $input->getArgument('number');
            $accountId = (int)$input->getArgument('account');
            $account = $this->accountRepository->findById($accountId);
            if(!$account){
                $output->writeln("Account number $accountId doesn't exsist");
                return Command::FAILURE;
            }

            for ($i = 0; $i < $number; $i++) {
                try {
                    $request = new CreateTransactionRequest(
                        rand(10,1000),
                        'Transaction #' . $i,
                        rand(1,2),
                        $accountId
                    );
                    $response = ($this->useCase)($request);
                    $output->writeln('Transaction created: ' . $response->id);
                } catch (Throwable $e) {
                    $output->writeln('Transaction #' . $i . 'could not be created');
                    $output->writeln($e->getMessage());
                }
            }
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
