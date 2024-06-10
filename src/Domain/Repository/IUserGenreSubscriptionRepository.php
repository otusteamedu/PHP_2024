<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserGenreSubscription;

interface IUserGenreSubscriptionRepository
{
    public function save(UserGenreSubscription $subscription): void;
}
