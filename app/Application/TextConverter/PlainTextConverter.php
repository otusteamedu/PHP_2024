<?php

namespace App\Application\TextConverter;

class PlainTextConverter implements TextConverterInterface
{

    /**
     * Simple convert from HTML to plain-text
     * @param string $input
     * @return string
     */
    public function convert(string $input): string
    {
        return strip_tags($input);
    }
}
