<?php

namespace Src\Domain\Entity;

use DateTime;
use Src\Domain\ValueObject\UserId;

class Statement
{
    private UserId $user_id;
    private DateTime $from_date;
    private DateTime $to_date;

    public function __construct(UserId $user_id, DateTime $from_date, DateTime $to_date)
    {
        $this->user_id = $user_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getFromDate(): DateTime
    {
        return $this->from_date;
    }

    public function getToDate(): DateTime
    {
        return $this->to_date;
    }

    public function getUserId(): UserId
    {
        return $this->user_id;
    }
}
