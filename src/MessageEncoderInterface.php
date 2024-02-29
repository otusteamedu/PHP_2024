<?php

declare(strict_types=1);

namespace App;

interface MessageEncoderInterface
{
    public function encode(string $message): string;
    public function decode(string $message): string;
}