<?php

declare(strict_types=1);

namespace App\Infrastructure\Observer;

use App\Domain\Entity\News;
use App\Domain\Observer\SubscribeInterface;
use App\Infrastructure\Repository\SubscribeRepository;

class NewsCreate implements SubscribeInterface
{

    public function create(News $news): void
    {
        $Repo = new SubscribeRepository();
        $user_ids = $Repo->getByCategory($news->getCategory());
        if (!empty($user_ids)) {
            // уведомить пользователей о новой новости
        }
    }
}