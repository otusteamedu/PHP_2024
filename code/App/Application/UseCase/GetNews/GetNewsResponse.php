<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNews;

class GetNewsResponse
{
    public int $id;
    public string $text;
    public function __construct(
        int $id,
        string $text
    )
    {
        $this->id = $id;
        $this->text = $text;
    }
}