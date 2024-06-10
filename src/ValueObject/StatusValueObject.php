<?php

declare(strict_types=1);

namespace App\ValueObject;

enum StatusValueObject: string
{
    case Pending = "Pending";
    case Processing = "Processing";
    case Completed = "Completed";
}
