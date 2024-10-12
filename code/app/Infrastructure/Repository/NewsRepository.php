<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\ExportDate;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use ReflectionProperty;

class NewsRepository implements NewsRepositoryInterface
{
    const TABLE_NAME = 'news';

    public function __construct()
    {
    }

    /**
     * @param integer $id
     * @return News|null
     */
    public function getById(int $id): ?News
    {
        $newsCollection = DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->get();

        if ($newsCollection->isEmpty()) {
            return null;
        }

        $newsRaw = $newsCollection->get(0);

        $news = new News(
            new Url($newsRaw->url),
            new Title($newsRaw->title),
            new ExportDate($newsRaw->export_date)
        );

        $this->setId($newsRaw->id, $news);

        return $news;
    }

    /**
     *
     * @return News[]
     */
    public function getAll(): iterable
    {
        $newsCollection = DB::table(self::TABLE_NAME)->get();

        $result = [];

        foreach ($newsCollection as $newsRaw) {
            try {
                $news = new News(
                    new Url($newsRaw->url),
                    new Title($newsRaw->title),
                    new ExportDate($newsRaw->export_date)
                );
                $this->setId($newsRaw->id, $news);
                $result[] = $news;
            } catch (InvalidArgumentException) {
                continue;
            }
        }

        return $result;
    }

    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void
    {
        if (is_null($news->getId())) {
            $this->insert($news);
        } else {
            $this->update($news);
        }
    }

    /**
     * @param News $news
     * @return void
     */
    public function delete(News $news): void
    {
        DB::table(self::TABLE_NAME)
            ->delete($news->getId());
    }

    private function insert(News $news): void
    {
        DB::table(self::TABLE_NAME)
            ->insert([
                'url' => $news->getUrl()->getValue(),
                'title' => $news->getTitle()->getValue(),
                'export_date' => $news->getExportDate()->getValue()->format('Y-m-d')
            ]);
        $newsId = DB::getPdo()->lastInsertId();

        $this->setId(
            (int)$newsId,
            $news
        );
    }

    private function update(News $news): void
    {
        DB::table(self::TABLE_NAME)
            ->where('id', $news->getId())
            ->update(
                [
                    'url' => $news->getUrl()->getValue(),
                    'title' => $news->getTitle()->getValue(),
                    'export_date' => $news->getExportDate()->getValue()->format('Y-m-d')
                ]
            );
    }

    /**
     * @param int $id
     * @param News $news
     * @return void
     */
    private function setId(int $id, News $news): void
    {
        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);
    }
}
