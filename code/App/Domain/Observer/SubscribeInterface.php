<?php


namespace App\Domain\Observer;

use App\Domain\Entity\News;

interface SubscribeInterface
{
    public function create(News $news): void;
}