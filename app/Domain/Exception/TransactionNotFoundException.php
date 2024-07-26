<?php

namespace App\Domain\Exception;

class TransactionNotFoundException extends \Exception
{
    protected $message = 'Transaction not found';
}