<?php

declare(strict_types=1);

namespace App\Domain\Entity\News;

use App\Domain\ValueObject\{NewsTitle, Url};
use Illuminate\Support\Collection;

class NewsMapper
{
    public function __construct(private NewsRepositoryInterface $repository)
    {
    }

    public function save(News $news): void
    {
        $this->repository->save($news);
    }

    public function findByIds(array $ids): Collection
    {
        $news = $this->repository->findByIds($ids);

        return $news->map($this->toModel(...));
    }

    public function all(): Collection
    {
        $news = $this->repository->all();

        return $news->map($this->toModel(...));
    }

    private function toModel(object $source): News
    {
        $news = new News(new Url($source->url), new NewsTitle($source->title));

        return $news->fill($source);
    }
}
