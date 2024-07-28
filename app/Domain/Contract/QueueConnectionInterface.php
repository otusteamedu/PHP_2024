<?php

namespace App\Domain\Contract;

interface QueueConnectionInterface
{
    public function channel();
}
