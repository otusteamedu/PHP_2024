<?php

namespace App\Application\UseCase\CreateAccount;

use App\Application\Gateway\BankGatewayRequest;
use App\Application\UseCase\SubmitLead\SubmitLeadRequest;
use App\Application\UseCase\SubmitLead\SubmitLeadResponse;
use App\Domain\Factory\AccountFactoryInterface;
use App\Domain\Repository\AccountRepositoryInterface;

class CreateAccountUseCase
{
    public function __construct(
        private readonly AccountFactoryInterface $accountFactory,
        private readonly AccountRepositoryInterface  $accountRepository
    )
    {
    }

    public function __invoke(CreateAccountRequest $request): CreateAccountResponse
    {
        $account = $this->accountFactory->create($request->holderName, $request->holderEmail);
        $this->accountRepository->save($account);
        return new CreateAccountResponse(
            $account->getId()
        );
    }
}