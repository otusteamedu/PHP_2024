<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Param;
use App\Domain\ValueObject\Priority;

class Condition
{
    private Param $param;
    private Name $name;

    public function __construct(Name $name, Param $param)
    {
        $this->name = $name;
        $this->param = $param;
    }

    public function getParam(): Param
    {
        return $this->param;
    }
    public function getName(): Name
    {
        return $this->name;
    }
}
