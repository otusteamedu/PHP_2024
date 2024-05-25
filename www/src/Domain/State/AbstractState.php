<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\State\ConcreteStates\Deleted;
use App\Domain\State\ConcreteStates\Draft;
use App\Domain\State\ConcreteStates\Moderation;
use App\Domain\State\ConcreteStates\Published;
use App\Domain\State\ConcreteStates\Updated;
use App\Domain\State\Exceptions\AllowedStatesNotDeclaredException;
use App\Domain\State\Exceptions\UnexpectedStateScalarMappingException;
use App\Domain\State\Exceptions\UnexpectedStateTransitionException;
use Exception;

abstract class AbstractState
{
    protected array $allowedStates;

    abstract public static function getName(): string;

    protected const MAP_SCALAR_STATE_CLASS = [
        -1 => Deleted::class,
        0 => Draft::class,
        1 => Moderation::class,
        2 => Published::class,
        3 => Updated::class,
    ];

    abstract public function getNewsNotificationCallback(int $newsId): callable;

    /**
     * @throws UnexpectedStateScalarMappingException
     */
    public static function getStateFromScalar(int $state): AbstractState
    {
        try {
            $class = self::MAP_SCALAR_STATE_CLASS[$state];
            return new $class();
        } catch (Exception $e) {
            throw new UnexpectedStateScalarMappingException($state);
        }
    }

    public function toScalar()
    {
        return self::getScalarFromState($this);
    }

    public static function getScalarFromState(AbstractState $state): int
    {
        return array_search($state::class, self::MAP_SCALAR_STATE_CLASS, true);
    }

    /**
     * @throws UnexpectedStateTransitionException
     * @throws AllowedStatesNotDeclaredException
     */
    public function getAllowedTransition(AbstractState $newState): AbstractState
    {
        if (!$this->allowedStates) {
            throw new AllowedStatesNotDeclaredException($this);
        }
        if (in_array($newState::class, $this->allowedStates)) {
            return $newState;
        }

        throw new UnexpectedStateTransitionException($this, $newState);
    }
}
