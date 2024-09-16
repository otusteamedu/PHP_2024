<?php

declare(strict_types=1);

namespace Viking311\Chat\Input;

class Reader
{
    public function __construct(
        private $inStream,
        private $outStream
    )
    {
    }

    /**
     * @param string $prompt
     * @return false|string
     */
    public function readLine(string $prompt = ''): false|string
    {
        if (!empty($prompt)) {
            fwrite($this->outStream, $prompt);
        }
        return stream_get_line($this->inStream, 1024, PHP_EOL);
    }
}
