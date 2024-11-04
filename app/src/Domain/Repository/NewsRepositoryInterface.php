<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    #насколько тут корретно на вход и на выход массивы принимать? не нужно ли объекты?
    #но тогда для объектов нужно тоже Entity создавать на уровне Domain видимо. с findAll аналогичный вопрос
    public function findByIds(iterable $ids): iterable;

    public function findAll(): iterable;

    #public function delete(News $news): void;
}
