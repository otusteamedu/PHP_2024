<?php

namespace App\Contracts;

interface QueueTaskHandlerInterface
{
    public function handle($data): void;
}