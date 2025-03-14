<?php

namespace App\Application\TextConverter;

use App\Application\TextConverter\TextConverterInterface;

class DummyConverter implements TextConverterInterface
{

    public function convert(string $input): string
    {
        return $input;
    }
}
