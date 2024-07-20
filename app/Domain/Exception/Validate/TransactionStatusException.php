<?php

declare(strict_types=1);

namespace App\Domain\Exception\Validate;

class TransactionStatusException extends \Exception
{
    protected $message = 'Transaction status failed';
}