<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use Application\Services\ShowService;
use Domain\Entities\Show;
use Domain\Repositories\ShowRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ShowServiceTest extends TestCase
{
    private ShowService $service;
    private ShowRepositoryInterface $repositoryMock;
    private Show $testEntity;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Создаем мок
        $this->repositoryMock = $this->createMock(ShowRepositoryInterface::class);
        // Передаем repositoryMock в Service
        $this->service = new ShowService($this->repositoryMock);
        // Создаем тестовую сущность
        $this->testEntity = static::getTestEntity();
    }

    protected static function getTestEntity(?int $id = 1, int $movie_id = 1, int $theatre_id = 1, string $time_zone = 'Europe/Moscow'): Show
    {
        $entity = new Show();
        $entity->id = $id;
        $entity->movie_id = $movie_id;
        $entity->theatre_id = $theatre_id;
        $entity->start = (new \DateTimeImmutable())->setTimezone(new \DateTimeZone($time_zone));

        return $entity;
    }

    protected function prepareRepositoryMock(string $method, null|string|object|array $expectedReturn = null): void
    {
        if (is_null($expectedReturn)) {
            $this->repositoryMock
                ->expects($this->once())
                ->method($method);
        } else {
            $this->repositoryMock
                ->expects($this->once())
                ->method($method)
                ->willReturn($expectedReturn);
        }
    }


    public function testGetAllEntities(): void
    {
        $expectedEntities = [
            $this->testEntity,
            static::getTestEntity(2),
        ];

        $this->prepareRepositoryMock('findAll', $expectedEntities);

        // Вызываем метод и проверяем результат
        $entities = $this->service->getAllShows();
        $this->assertIsArray($entities);
        $this->assertCount(2, $entities);
        $this->assertEquals($expectedEntities, $entities);
    }

    public function testGetEntityById(): void
    {
        $this->prepareRepositoryMock('findById', $this->testEntity);

        // Вызываем метод и проверяем результат
        $entity = $this->service->getShowById(1);
        $this->assertInstanceOf(Show::class, $entity);
        $this->assertEquals(1, $entity->id);
    }

    public function testCreateEntity(): void
    {
        $newEntity = static::getTestEntity(null);

        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->createShow($newEntity);
        $this->assertEquals('1', $id);
    }

    public function testUpdateEntity(): void
    {
        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->updateShow($this->testEntity);
        $this->assertEquals('1', $id);
    }

    public function testDeleteEntity(): void
    {
        $this->prepareRepositoryMock('delete');

        // Вызываем метод
        $this->service->deleteShow(1);
    }
}
