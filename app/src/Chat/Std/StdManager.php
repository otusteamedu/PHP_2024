<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Chat\Std;

class StdManager
{
    public function readLine(string $prompt): string
    {
        $message = '';
        while (empty($message)) {
            $input = readline($prompt);
            $message = trim($input);
        }
        return $message;
    }

    public function printMessage(string $message): void
    {
        $message .= "\n";
        fwrite(STDOUT, $message);
    }
}
