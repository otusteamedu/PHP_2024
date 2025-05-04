<?php
namespace App;

use App\Events\BurgerEventInterface;
use App\Strategy\BurgerStrategy;

class Kitchen
{
    private ?BurgerEventInterface $events = null;

    public function setEvents(BurgerEventInterface $events): void
    {
        $this->events = $events;
    }

    public function createBurger(BurgerStrategy $strategy): Builder
    {
        $builder = new Builder($strategy);

        if ($this->events) {
            $this->events->preProcess($builder->getInProgressBurger());
        }

        return $builder;
    }
}