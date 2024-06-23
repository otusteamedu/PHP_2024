<?php

declare(strict_types=1);

namespace App\Observe;

interface ObserverInterface
{
    public function update(SubjectInterface $subject): void;
}
