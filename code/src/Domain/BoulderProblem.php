<?php

declare(strict_types=1);

namespace Irayu\Hw0\Domain;

class BoulderProblem
{
    private int $id;
    private string $name;
    private string $grade; // e.g., V5, V8
    private int $top;      // Score for reaching the top
    private int $zone;     // Score for reaching the zone
    private int $maxAttempts; // Maximum allowed attempts

    public function __construct(int $id, string $name, string $grade, int $top, int $zone, int $maxAttempts)
    {
        $this->id = $id;
        $this->name = $name;
        $this->grade = $grade;
        $this->top = $top;
        $this->zone = $zone;
        $this->maxAttempts = $maxAttempts;
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
