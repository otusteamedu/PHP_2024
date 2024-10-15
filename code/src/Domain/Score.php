<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain;

class Score
{
    public function __construct(
        public readonly  int $userId,
        public readonly  int $problemId,
        private int $attempts,
        public readonly  bool $topAchieved,
        public readonly  bool $zoneAchieved,
        public readonly  int $score
    ) {
    }
}
