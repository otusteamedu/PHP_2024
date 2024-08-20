<?php

namespace App\Domain\Entity;


use App\Domain\ValueObject\AccountValueObject;
use App\Domain\ValueObject\AmountValueObject;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\EmailValueObject;

class OrderEntity
{

    private int $status = 1;
    private CurrencyValueObject $curFrom;
    private CurrencyValueObject $curTo;
    private AmountValueObject $amountFrom;
    private AmountValueObject $amountTo;
    private AmountValueObject $rateFrom;
    private AmountValueObject $rateTo;
    private EmailValueObject $email;
    private AccountValueObject $recipientAccount;
    private AccountValueObject $incomingAsset;

    public function __construct(
        CurrencyValueObject $curFrom,
        CurrencyValueObject $curTo,
        AmountValueObject $amountFrom,
        AmountValueObject $amountTo,
        AmountValueObject $rateFrom,
        AmountValueObject $rateTo,
        EmailValueObject $email,
        AccountValueObject $recipientAccount,
        AccountValueObject $incomingAsset = null,
    )
    {
        $this->curFrom = $curFrom;
        $this->curTo = $curTo;
        $this->amountFrom = $amountFrom;
        $this->amountTo = $amountTo;
        $this->rateFrom = $rateFrom;
        $this->rateTo = $rateTo;
        $this->email = $email;
        $this->recipientAccount = $recipientAccount;
        $this->incomingAsset = $incomingAsset;
    }

    public function getCurFrom(): string
    {
        return $this->curFrom->currencyCode;
    }

    public function getCurTo(): string
    {
        return $this->curTo->currencyCode;
    }

    public function getAmountFrom(): string
    {
        return $this->amountFrom->amount;
    }

    public function getAmountTo(): string
    {
        return $this->amountTo->amount;
    }

    public function getRateFrom(): string
    {
        return $this->rateFrom->amount;
    }

    public function getRateTo(): string
    {
        return $this->rateTo->amount;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getEmail(): string
    {
        return $this->email->email;
    }

    public function getRecipientAccount(): string
    {
        return $this->recipientAccount->account;
    }

    public function getIncomingAsset(): string
    {
        return $this->incomingAsset->account;
    }

    public function setIncomingAsset(string $incomingAsset): void
    {
        $this->incomingAsset->account = $incomingAsset;
    }


}
