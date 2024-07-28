<?php

declare(strict_types=1);

namespace App\Domain\Exception\Validate;

class TransactionTypeException extends \Exception
{
    protected $message = 'Transaction type failed';
}
