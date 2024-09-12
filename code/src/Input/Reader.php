<?php

declare(strict_types=1);

namespace Viking311\Chat\Input;

class Reader
{
    /**
     * @param string $caption
     * @return false|string
     */
    public function readLine(string $prompt = ''): false|string
    {
        return readline($prompt);
    }
}
