<?php


declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Response;
use Throwable;

class ValidatorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function withMessage(): string
    {
        return new Response($this->message) . '<br>';
    }
}