<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\News\{News, NewsRepositoryInterface};
use App\Domain\ValueObject\{NewsTitle, Url};
use Illuminate\Support\Collection;

class DatabaseNewsRepository extends AbstractDatabaseRepository implements NewsRepositoryInterface
{
    protected static string $table = 'news';

    public function save(News $news): int
    {
        return $this->dbManager->table('news')->insertGetId([
            'url' => $news->getUrl()->getValue(),
            'title' => $news->getTitle()->getValue(),
        ]);
    }

    public function findWhereIn(array $values, ?string $column = 'id'): Collection
    {
        return parent::findWhereIn($values, $column)->map($this->toModel(...));
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
}
