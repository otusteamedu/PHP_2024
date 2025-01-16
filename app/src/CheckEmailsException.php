<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusVerificationEmailApp;

use Exception;

class CheckEmailsException extends Exception
{
    protected $message = 'Список email пуст!';
}
