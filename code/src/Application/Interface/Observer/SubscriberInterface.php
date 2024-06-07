<?php
declare(strict_types=1);

namespace App\Application\Interface\Observer;

interface SubscriberInterface
{
    public function update(int $status): void;
}