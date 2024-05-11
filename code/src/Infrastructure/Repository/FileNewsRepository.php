<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Repository;

use Irayu\Hw15\Domain;

class FileNewsRepository implements Domain\Repository\NewsRepositoryInterface
{
    private $filename;
    private $lastId = 0;

    private const DATE_FORMAT = 'Y-m-d';
    public function __construct($filename)
    {
        $this->filename = $filename;
        if (!file_exists($this->filename)) {
            $f = fopen($this->filename, 'w');
            fclose($f);
        }
    }

    public function save(Domain\Entity\NewsItem $newsItem): void
    {
        $data = $this->load();
        $data['lastId'] = ++$this->lastId;
        $data['items'][$this->lastId] = [
            'url' => $newsItem->getUrl()->getValue(),
            'title' => $newsItem->getTitle()->getValue(),
            'date' => $newsItem->getDate()->getValue()->format(static::DATE_FORMAT),
        ];

        file_put_contents($this->filename, json_encode($data));

        (new \ReflectionProperty(Domain\Entity\NewsItem::class, 'id'))
            ->setValue($newsItem, $this->lastId)
        ;
    }

    private function load()
    {
        $data = file_get_contents($this->filename);
        $data = json_decode($data, true);
        if (!(is_array($data) && array_key_exists('lastId', $data) && array_key_exists('items', $data))) {
            $data = ['lastId' => 0, 'items' => []];
        }
        $this->lastId = (int)$data['lastId'];
        return $data;
    }

    public function findById(int $id): ?Domain\Entity\NewsItem
    {
        $data = $this->load();
        if (array_key_exists($id, $data['items'])) {
            return new Domain\Entity\NewsItem(
                new Domain\ValueObject\Url($data['items'][$id]['url']),
                new Domain\ValueObject\Title($data['items'][$id]['title']),
                new Domain\ValueObject\Date(\DateTime::createFromFormat(static::DATE_FORMAT, $data['items'][$id]['date'])),
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $data = $this->load();
        $result = array_map(
            [$this, 'createNewsItem'],
            array_values($data['items']),
            array_keys($data['items'])
        );

        return $result;
    }

    public function getByPage(int $pageNumber, int $pageSize): array
    {
        // TODO: Implement getByPage() method.
        return [];
    }

    private static function createNewsItem($item, $id): Domain\Entity\NewsItem
    {
        $newsItem = new Domain\Entity\NewsItem(
            new Domain\ValueObject\Url($item['url']),
            new Domain\ValueObject\Title($item['title']),
            new Domain\ValueObject\Date(\DateTime::createFromFormat(static::DATE_FORMAT, $item['date'])),
        );

       (new \ReflectionProperty($newsItem::class, 'id'))
           ->setValue($newsItem, $id)
       ;

        return $newsItem;
    }
}