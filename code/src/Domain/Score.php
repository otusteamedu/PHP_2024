<?php

declare(strict_types=1);

namespace Irayu\Hw0\Domain;

class Score
{
    private int $userId;
    private int $problemId;
    private int $attempts;
    private bool $topAchieved;
    private bool $zoneAchieved;
    private int $score;

    public function __construct(int $userId, int $problemId, int $attempts, bool $topAchieved, bool $zoneAchieved, int $score)
    {
        $this->userId = $userId;
        $this->problemId = $problemId;
        $this->attempts = $attempts;
        $this->topAchieved = $topAchieved;
        $this->zoneAchieved = $zoneAchieved;
        $this->score = $score;
    }
}
