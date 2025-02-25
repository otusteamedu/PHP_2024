<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use Application\Services\TheatreService;
use Domain\Entities\Theatre;
use Domain\Repositories\TheatreRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TheatreServiceTest extends TestCase
{
    private TheatreService $service;
    private TheatreRepositoryInterface $repositoryMock;
    private Theatre $testEntity;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Создаем мок
        $this->repositoryMock = $this->createMock(TheatreRepositoryInterface::class);
        // Передаем repositoryMock в Service
        $this->service = new TheatreService($this->repositoryMock);
        // Создаем тестовую сущность
        $this->testEntity = static::getTestEntity();
    }

    protected static function getTestEntity(?int $id = 1, string $title = 'Grand Cinema Theatre', string $location = 'Some location'): Theatre
    {
        $entity = new Theatre();
        $entity->id = $id;
        $entity->title = $title;
        $entity->location = $location;
        $entity->capacity = 100;

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
            static::getTestEntity(2, 'Royal Theatre', 'London'),
        ];

        $this->prepareRepositoryMock('findAll', $expectedEntities);

        // Вызываем метод и проверяем результат
        $entities = $this->service->getAllTheatres();
        $this->assertIsArray($entities);
        $this->assertCount(2, $entities);
        $this->assertEquals($expectedEntities, $entities);
    }

    public function testGetEntityById(): void
    {
        $this->prepareRepositoryMock('findById', $this->testEntity);

        // Вызываем метод и проверяем результат
        $entity = $this->service->getTheatreById(1);
        $this->assertInstanceOf(Theatre::class, $entity);
        $this->assertEquals(1, $entity->id);
        $this->assertEquals($this->testEntity->title, $entity->title);
    }

    public function testCreateEntity(): void
    {
        $newEntity = static::getTestEntity(null, 'New Theatre', 'Paris');

        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->createTheatre($newEntity);
        $this->assertEquals('1', $id);
    }

    public function testUpdateEntity(): void
    {
        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->updateTheatre($this->testEntity);
        $this->assertEquals('1', $id);
    }

    public function testDeleteEntity(): void
    {
        $this->prepareRepositoryMock('delete');

        // Вызываем метод
        $this->service->deleteTheatre(1);
    }
}
