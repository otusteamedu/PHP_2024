<?php

namespace App\Domain\Exception\Validate;

class TransactionAccountNumberException extends \Exception
{
    protected $message = 'Invalid transaction account number.';
}