<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use ReflectionProperty;

class DbNewsRepository implements NewsRepositoryInterface
{

    const TABLE_NAME = 'news';

    public function __construct(
        private readonly NewsFactoryInterface $newsFactory
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function findAll(): iterable
    {
        return $this->findByIds([]);
    }

    public function findById(int $id): ?News
    {
        return $this->findByIds([$id])[0] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $ids): iterable
    {
        $data = DB::table(self::TABLE_NAME)
            ->when(!empty($ids), function ($query) use ($ids) {
                $query->whereIn('id', $ids);
            })
            ->get();

        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $newsList = [];
        foreach ($data as $row) {
            $news = $this->newsFactory->create($row->url, $row->title);
            $news->setDate(new \DateTime($row->date));
            $reflectionProperty->setValue($news, $row->id);
            $newsList[] = $news;
        }

        return $newsList;
    }

    public function save(News $news): void
    {
        $insertId = DB::table(self::TABLE_NAME)
            ->insertGetId([
                'title' => $news->getTitle()->getValue(),
                'url' => $news->getUrl()->getValue(),
                'date' => $news->getDate(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $insertId);
    }
}
