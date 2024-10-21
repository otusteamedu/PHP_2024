<?php

declare(strict_types=1);

namespace App\Domain\Interface;

use Generator;

interface ChatKeepingInterface
{
    public function initializeChat(): string;
    public function keepChat(): Generator;
    public function stopChat(): Generator;
}
