<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\Inn;
use Src\Domain\ValueObject\UserId;

class Counterparty
{
    private UserId $userId;
    private Inn $inn;

    public function __construct(UserId $userId, Inn $inn)
    {
        $this->userId = $userId;
        $this->inn = $inn;
    }

    public function getInn(): Inn
    {
        return $this->inn;
    }
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
