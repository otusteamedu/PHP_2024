<?php

declare(strict_types=1);

namespace App;

class Base64MessageEncoder implements MessageEncoderInterface
{
    public function encode(string $message): string
    {
        return base64_encode($message);
    }

    public function decode(string $message): string
    {
        return (string) base64_decode($message);
    }
}
