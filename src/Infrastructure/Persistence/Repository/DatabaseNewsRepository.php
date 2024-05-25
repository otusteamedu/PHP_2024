<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\News\{News, NewsRepositoryInterface};
use App\Domain\ValueObject\{NewsTitle, Url};
use Illuminate\Support\Collection;
use ReflectionClass;

class DatabaseNewsRepository extends AbstractDatabaseRepository implements NewsRepositoryInterface
{
    protected static string $table = 'news';

    public function save(News $news): void
    {
        $id = $this->dbManager->table('news')->insertGetId([
            'url' => $news->getUrl()->getValue(),
            'title' => $news->getTitle()->getValue(),
        ]);

        $news = $this->setId($news, $id);
    }

    public function findByIds(array $values): Collection
    {
        return parent::findByIds($values)->map($this->toModel(...));
    }

    public function all(): Collection
    {
        return parent::all()->map($this->toModel(...));
    }

    private function toModel(object $source): News
    {
        $news = new News(new Url($source->url), new NewsTitle($source->title));

        return $news->fill($source);
    }

    private function setId(News $news, int $id): News
    {
        $reflectionClass = new ReflectionClass($news);
        $property = $reflectionClass->getProperty('id');
        $property->setValue($news, $id);

        return $news;
    }
}
