<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw4;

use Exception;
use Apeskovatzkov\Hw4\Utils\StringValidator;

class Application
{
    public function run(): void
    {
        session_start();

        try {
            StringValidator::validateBrackets($_POST['string'] ?? '');
            $this->emitResponse("Все хорошо\n", 200);
        } catch (Exception $e) {
            $this->emitResponse($e->getMessage(), 400);
        }
    }

    public function emitResponse(mixed $body, int $status): void
    {
        http_response_code($status);
        echo $body;
    }
}
