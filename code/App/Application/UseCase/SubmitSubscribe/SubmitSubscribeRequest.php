<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitSubscribe;

class SubmitSubscribeRequest
{
    public int $user_id;
    public string $category;
    public function __construct(
        int $user_id,
        string $category
    )
    {
        $this->user_id = $user_id;
        $this->category = $category;
    }
}