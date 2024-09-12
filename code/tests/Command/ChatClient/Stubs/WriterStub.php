<?php

declare(strict_types=1);

namespace Test\Command\ChatClient\Stubs;

use Viking311\Chat\Output\Writer;

class WriterStub extends Writer
{
    private array $buffer = [];

    public function write(string $message): void
    {
        $this->buffer[] = $message;
    }

    /**
     * @return array
     */
    public function getBuffer(): array
    {
        return $this->buffer;
    }

}
