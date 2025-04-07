<?php

namespace Irayu\Hw16\Application;

interface Observer
{
    public function update(ObserverEvent $event): void;
}
