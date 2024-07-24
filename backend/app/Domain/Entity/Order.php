<?php

namespace app\Domain\Entity;


use App\Domain\ValueObject\AmountValueObject;
use App\Domain\ValueObject\CurrencyValueObject;

class Order
{

    private CurrencyValueObject $curFrom;
    private CurrencyValueObject $curTo;
    private AmountValueObject $amountFrom;
    private AmountValueObject $amountTo;
    private AmountValueObject $rate;

    public function __construct(
        CurrencyValueObject $curFrom,
        CurrencyValueObject $curTo,
        AmountValueObject $amountFrom,
        AmountValueObject $amountTo,
        AmountValueObject $rate
    )
    {
        $this->curFrom = $curFrom;
        $this->curTo = $curTo;
        $this->amountFrom = $amountFrom;
        $this->amountTo = $amountTo;
        $this->rate = $rate;
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

    public function getRate(): string
    {
        return $this->rate->amount;
    }


}
