<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use Application\Services\TicketService;
use Domain\Entities\Ticket;
use Domain\Repositories\TicketRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TicketServiceTest extends TestCase
{
    private TicketService $service;
    private TicketRepositoryInterface $repositoryMock;
    private Ticket $testEntity;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Создаем мок
        $this->repositoryMock = $this->createMock(TicketRepositoryInterface::class);
        // Передаем repositoryMock в Service
        $this->service = new TicketService($this->repositoryMock);
        // Создаем тестовую сущность
        $this->testEntity = static::getTestEntity();
    }

    protected static function getTestEntity(?int $id = 1, int $show_id = 1, int $seat = 1, int $price = 500): Ticket
    {
        $entity = new Ticket();
        $entity->id = $id;
        $entity->show_id = $show_id;
        $entity->seat = $seat;
        $entity->price = $price;
        $entity->available = 1;

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
        $entities = $this->service->getAllTickets();
        $this->assertIsArray($entities);
        $this->assertCount(2, $entities);
        $this->assertEquals($expectedEntities, $entities);
    }

    public function testGetEntityById(): void
    {
        $this->prepareRepositoryMock('findById', $this->testEntity);

        // Вызываем метод и проверяем результат
        $entity = $this->service->getTicketById(1);
        $this->assertInstanceOf(Ticket::class, $entity);
        $this->assertEquals(1, $entity->id);
    }

    public function testCreateEntity(): void
    {
        $newEntity = static::getTestEntity(null);

        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->createTicket($newEntity);
        $this->assertEquals('1', $id);
    }

    public function testUpdateEntity(): void
    {
        $this->prepareRepositoryMock('save', '1');

        // Вызываем метод и проверяем результат
        $id = $this->service->updateTicket($this->testEntity);
        $this->assertEquals('1', $id);
    }

    public function testDeleteEntity(): void
    {
        $this->prepareRepositoryMock('delete');

        // Вызываем метод
        $this->service->deleteTicket(1);
    }
}
