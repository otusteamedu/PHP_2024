<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Subscribe;

interface SubscribeFactoryInterface
{
    public function create(int $user_id, string $category): Subscribe;
}