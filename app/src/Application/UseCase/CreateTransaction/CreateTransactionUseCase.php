<?php

namespace App\Application\UseCase\CreateTransaction;

use App\Application\Gateway\BankGatewayRequest;
use App\Application\UseCase\CreateAccount\CreateAccountRequest;
use App\Application\UseCase\CreateAccount\CreateAccountResponse;
use App\Application\UseCase\SubmitLead\SubmitLeadRequest;
use App\Application\UseCase\SubmitLead\SubmitLeadResponse;
use App\Domain\Factory\AccountFactoryInterface;
use App\Domain\Factory\TransactionFactoryInterface;
use App\Domain\Repository\AccountRepositoryInterface;
use App\Domain\Repository\TransactionRepositoryInterface;

class CreateTransactionUseCase
{
    public function __construct(
        private readonly TransactionFactoryInterface $accountFactory,
        private readonly TransactionRepositoryInterface  $accountRepository
    )
    {
    }

    public function __invoke(CreateTransactionRequest $request): CreateTransactionResponse
    {
        $account = $this->accountFactory->create(
            $request->amount,
            $request->description,
            $request->transactionType,
            $request->accountId
        );
        $this->accountRepository->save($account);
        return new CreateTransactionResponse(
            $account->getId()
        );
    }
}