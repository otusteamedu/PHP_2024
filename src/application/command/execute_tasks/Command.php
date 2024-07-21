<?php

namespace app\application\command\execute_tasks;

class Command
{
    public function __construct(
        public readonly string $id,
        public readonly array $data
    )
    {
    }
}
