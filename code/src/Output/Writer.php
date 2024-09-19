<?php

declare(strict_types=1);

namespace Viking311\Chat\Output;

class Writer
{
    /**
     * @param string $message
     * @return void
     */
    public function write(string $message): void
    {
        fwrite(STDOUT, $message);
    }
}
