<?php

namespace app\application\command\check_tasks;

class Command
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}
