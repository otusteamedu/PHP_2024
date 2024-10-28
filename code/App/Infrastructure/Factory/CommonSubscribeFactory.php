<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Subscribe;
use App\Domain\Factory\SubscribeFactoryInterface;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\UserId;

class CommonSubscribeFactory implements SubscribeFactoryInterface
{

    public function create(int $user_id, string $category): Subscribe
    {
        return new Subscribe(
            new UserId($user_id),
            new Category($category)
        );
    }
}