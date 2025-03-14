<?php

namespace App\Application\TextConverter;

interface TextConverterInterface
{
    public function convert(string $input): string;
}
