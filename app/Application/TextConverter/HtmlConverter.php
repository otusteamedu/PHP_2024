<?php

namespace App\Application\TextConverter;

use App\Application\TextConverter\TextConverterInterface;

class HtmlConverter implements TextConverterInterface
{

    public function convert(string $input): string
    {
        return $input;
    }
}
