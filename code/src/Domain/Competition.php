<?php

declare(strict_types=1);

namespace Irayu\Hw0\Domain;

class Competition
{
    private int $id;
    private string $name;
    private string $location;
    private DateTime $date;
    private array $boulderProblems; // Array of BoulderProblem entities

    public function __construct(int $id, string $name, string $location, DateTime $date, array $boulderProblems = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->date = $date;
        $this->boulderProblems = $boulderProblems;
    }

    public function addBoulderProblem(BoulderProblem $problem): void
    {
        $this->boulderProblems[] = $problem;
    }
}
