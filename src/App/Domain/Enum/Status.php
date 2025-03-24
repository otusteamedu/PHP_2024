<?php

namespace App\Domain\Enum;

enum Status
{
    case START;
    case COOKING;
    case SUCCESS;
    case FAILED;
}