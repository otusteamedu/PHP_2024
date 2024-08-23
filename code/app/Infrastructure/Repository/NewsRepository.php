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

class NewsRepository implements NewsRepositoryInterface
{
    const TABLE_NAME = 'news';

    public function __construct() {}
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

        return new News(
            new Url($newsRaw->url),
            new Title($newsRaw->title),
            new ExportDate($newsRaw->export_date),
            $newsRaw->id
        );
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
                $result[] = new News(
                    new Url($newsRaw->url),
                    new Title($newsRaw->title),
                    new ExportDate($newsRaw->export_date),
                    $newsRaw->id
                );
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

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsId);
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
}
