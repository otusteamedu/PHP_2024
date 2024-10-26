<?php

namespace App\Domain\Output;

use App\Domain\ValueObject\Text;

interface AppendedTextInterface
{
    public function getText(): Text;
}