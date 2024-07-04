<?php

namespace App\Application\Interface;

use App\Application\DTO\DTO;

interface QueueAddMsgInterface
{
    public function add(DTO $request): void;
}