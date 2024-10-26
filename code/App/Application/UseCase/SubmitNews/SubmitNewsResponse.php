<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

class SubmitNewsResponse
{
    public int $id;
    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }
}