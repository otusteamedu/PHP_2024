<?php

declare(strict_types=1);

namespace Test\Stubs;

use Viking311\Chat\Input\Reader;

class ReaderStub extends Reader
{
    private array $inputs = [
        'message1',
        'message2',
        'exit'
    ];
    private static int $index = -1;

    /**
     * @param string $prompt
     * @return false|string
     */
    public function readLine(string $prompt = ''): false|string
    {
        self::$index++;
        return $this->inputs[self::$index];
    }

}
