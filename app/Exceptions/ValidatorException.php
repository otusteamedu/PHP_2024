<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Base\Response;
use Throwable;

class ValidatorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->withMessage();
    }

    public function withMessage(): void
    {
        echo new Response($this->message, 422) . '<br>';
    }

}
