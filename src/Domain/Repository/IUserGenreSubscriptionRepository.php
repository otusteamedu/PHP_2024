<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Application\Repository\DTO\FindUserByGenreSubscriptionDto;
use App\Domain\Entity\UserGenreSubscription;

interface IUserGenreSubscriptionRepository
{
    public function findUsersSubscribedToGenre(FindUserByGenreSubscriptionDto $query): array;
    public function save(UserGenreSubscription $subscription): void;
}
