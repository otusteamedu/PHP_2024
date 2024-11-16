<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Account;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\DateTime;
use App\Domain\ValueObject\Email;

class BankStatement
{
    public function __construct(private Account $account, private Date $dateFrom, private Date $dateTo, private DateTime $dateTime, private Email $email)
    {
    }
}
