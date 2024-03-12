<?php

declare(strict_types=1);

namespace AShutov\Hw6;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(string $path): string
    {
        $arrEmails = (new Reader())->readFile($path);

        return (new EmailValidator())->validate($arrEmails);
    }
}
