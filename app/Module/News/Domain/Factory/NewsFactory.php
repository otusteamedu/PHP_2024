<?php

declare(strict_types=1);

namespace Module\News\Domain\Factory;

use Core\Domain\Factory\UuidFactoryInterface;
use Core\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Module\News\Domain\Entity\News;
use Module\News\Domain\Entity\NewsCollection;
use Module\News\Domain\Exception\IncorrectNewsDataException;
use Module\News\Domain\Exception\IncorrectNewsDataTypeException;
use Module\News\Domain\ValueObject\Title;
use Module\News\Domain\ValueObject\Url;
use ReflectionObject;

use function is_array;

final readonly class NewsFactory
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory
    ) {
    }

    public function create(string $url, string $title): News
    {
        return new News($this->uuidFactory->next(), new Url($url), new Title($title));
    }

    /**
     * @throws IncorrectNewsDataException
     * @throws Exception
     */
    public function createByRaw(array $data): News
    {
        $this->ensureCorrectData($data);
        $news = new News(
            new Uuid($data['id']),
            new Url($data['url']),
            new Title($data['title'])
        );
        $this->setDate($news, new DateTimeImmutable($data['date']));

        return $news;
    }

    /**
     * @throws IncorrectNewsDataException
     * @throws Exception
     */
    public function createCollectionByRaw(array $data): NewsCollection
    {
        $collection = new NewsCollection();

        foreach ($data as $row) {
            $this->ensureCorrectDataType($row);
            $collection->add($this->createByRaw($row));
        }

        return $collection;
    }

    /**
     * @throws IncorrectNewsDataException
     */
    private function ensureCorrectData(array $data): void
    {
        if (isset($data['id'], $data['url'], $data['title'], $data['date'])) {
            return;
        }
        throw new IncorrectNewsDataException($data);
    }

    private function ensureCorrectDataType(mixed $data): void
    {
        if (!is_array($data)) {
            throw new IncorrectNewsDataTypeException($data);
        }
    }

    private function setDate(News $news, DateTimeInterface $date): void
    {
        $reflectionObject = new ReflectionObject($news);
        $reflectionProperty = $reflectionObject->getProperty('date');
        $reflectionProperty->setValue($news, $date);
    }
}
