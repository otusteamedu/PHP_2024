<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain;

class Competition
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $location,
        public readonly \DateTime $start,
        public readonly \DateTime $finish,
        private VO\BoulderProblemCollection $boulderProblems
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addBoulderProblem(BoulderProblem $problem): void
    {
        $this->boulderProblems[] = $problem;
    }

    public function getBoulderProblems(): VO\BoulderProblemCollection
    {
        return $this->boulderProblems->getLoaded();
    }
}
