<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use Application\Services\MovieService;
use Domain\Entities\Movie;
use Domain\Repositories\MovieRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class MovieServiceTest extends TestCase
{
    private MovieService $service;
    private MovieRepositoryInterface $repositoryMock;
    private Movie $testEntity;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Создаем мок
        $this->repositoryMock = $this->createMock(MovieRepositoryInterface::class);
        // Передаем repositoryMock в Service
        $this->service = new MovieService($this->repositoryMock);
        // Создаем тестовую сущность
        $this->testEntity = static::getTestEntity();
    }

    protected static function getTestEntity(?int $id = 1, string $title = 'Killers of the Flower Moon', string $genre = 'Genre'): Movie
    {
        $entity = new Movie();
        $entity->id = $id;
        $entity->title = $title;
        $entity->genre = $genre;

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
            static::getTestEntity(2, 'Oppenheimer', 'Genre'),
        ];

        $this->prepareRepositoryMock('findAll', $expectedEntities);

        // Вызываем метод и проверяем результат
        $entities = $this->service->getAllMovies();
        $this->assertIsArray($entities);
        $this->assertCount(2, $entities);
        $this->assertEquals($expectedEntities, $entities);
    }

    public function testGetEntityById(): void
    {
        $this->prepareRepositoryMock('findById', $this->testEntity);

        // Вызываем метод и проверяем результат
        $entity = $this->service->getMovieById(1);
        $this->assertInstanceOf(Movie::class, $entity);
        $this->assertEquals(1, $entity->id);
        $this->assertEquals($this->testEntity->title, $entity->title);
    }

    public function testCreateEntity(): void
    {
        $newEntity = static::getTestEntity(null, 'Oppenheimer', 'Genre');

        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->createMovie($newEntity);
        $this->assertEquals('1', $id);
    }

    public function testUpdateEntity(): void
    {
        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->updateMovie($this->testEntity);
        $this->assertEquals('1', $id);
    }

    public function testDeleteEntity(): void
    {
        $this->prepareRepositoryMock('delete');

        // Вызываем метод
        $this->service->deleteMovie(1);
    }
}
