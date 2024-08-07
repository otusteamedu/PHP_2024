<?php

namespace app\application\command\add_tasks;

class Command
{
    public function __construct(
        public readonly string $phone
    )
    {
    }
}
