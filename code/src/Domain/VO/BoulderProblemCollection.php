<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain\VO;

abstract class BoulderProblemCollection extends \SplDoublyLinkedList
{
    public function __construct(
        protected array $boulderProblems,
    ) {
        foreach ($this->boulderProblems as $boulderProblem) {
            $this->push($boulderProblem);
        }
    }
    // For the LazyCollection
    abstract public function getLoaded(): static;
}
