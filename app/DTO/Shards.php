<?php

namespace App\DTO;

readonly class Shards
{
    public int $total;
    public int $successful;
    public int $skipped;
    public int $failed;

    public function __construct(array $shards)
    {
        $this->total = $shards['total'] ?? 0;
        $this->successful = $shards['successful'] ?? 0;
        $this->skipped = $shards['skipped'] ?? 0;
        $this->failed = $shards['failed'] ?? 0;
    }
}
