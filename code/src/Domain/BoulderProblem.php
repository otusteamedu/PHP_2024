<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain;

class BoulderProblem
{
    public function __construct(
        private int $id,
        private string $name,
        private string $grade,
        private int $top,
        private int $zone,
        private int $maxAttempts
    ) {
    }

    public function calculateScore(int $attempts, bool $topAchieved, bool $zoneAchieved): int
    {
        // Calculate score based on attempts, top, and zone
        $score = 0;
        if ($topAchieved) {
            $score += $this->top;
        } elseif ($zoneAchieved) {
            $score += $this->zone;
        }
        return max(0, $score - $attempts); // Penalty for attempts
    }
}
