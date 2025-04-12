<?php

namespace Tests\Unit\Infrastructure\Repository;

use App\Domain\Entity\Lead;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Body;
use App\Domain\ValueObject\UserName;
use App\Infrastructure\Factory\LeadFactory;
use App\Infrastructure\Models\Lead as LeadModel;
use App\Infrastructure\Repository\DbLeadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use ReflectionProperty;

class DbLeadRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private LeadFactory $leadFactory;
    private DbLeadRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leadFactory = Mockery::mock(LeadFactory::class);
        $this->repository = new DbLeadRepository($this->leadFactory);
    }

    public function testFindByIdReturnsNullIfNotFound(): void
    {
        $this->assertNull($this->repository->findById(99999));
    }

    public function testFindByIdReturnsLead(): void
    {
        $model = LeadModel::factory()->create([
                                                  'user_name' => 'Иван Петров',
                                                  'email' => 'ivan@testmail.ru',
                                                  'body' => 'Заявка в банк',
                                                  'status' => Lead::STATUS_NEW,
                                                  'result' => null,
                                              ]);

        $expectedLead = new Lead(
            new UserName($model->user_name),
            new Email($model->email),
            new Body($model->body),
            $model->status,
            $model->result
        );

        $this->leadFactory
            ->shouldReceive('create')
            ->once()
            ->with(
                $model->user_name,
                $model->email,
                $model->body,
                $model->status,
                $model->result,
            )
            ->andReturn($expectedLead);

        $lead = $this->repository->findById($model->id);

        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertSame($model->id, $lead->getId());
    }

    public function testSaveCreatesNewModel(): void
    {
        $lead = $this->createLeadWithId(null);

        $this->repository->save($lead);

        $this->assertDatabaseHas('leads', [
            'user_name' => 'Иван Петров',
            'email' => 'ivan@testmail.ru',
            'body' => 'Заявка в банк',
            'status' => Lead::STATUS_NEW,
            'result' => null,
        ]);

        $this->assertNotNull($lead->getId());
    }

    public function testUpdateModifiesExistingModel(): void
    {
        $model = LeadModel::factory()->create([
                                                  'user_name' => 'Предыдущее имя',
                                                  'email' => 'old@testmail.ru',
                                                  'body' => 'Предыдущая заявка в банк',
                                                  'status' => Lead::STATUS_QUEUED,
                                                  'result' => null,
                                              ]);

        $lead = new Lead(
            new UserName('Новое имя'),
            new Email('new@testmail.ru'),
            new Body('Новая заявка'),
            Lead::STATUS_SUCCESS,
            json_encode('success')
        );

        $this->setLeadId($lead, $model->id);

        $this->repository->update($lead);

        $this->assertDatabaseHas('leads', [
            'id' => $model->id,
            'user_name' => 'Новое имя',
            'email' => 'new@testmail.ru',
            'body' => 'Новая заявка',
            'status' => Lead::STATUS_SUCCESS,
            'result' =>'success',
        ]);
    }

    private function createLeadWithId(?int $id): Lead
    {
        $lead = new Lead(
            new UserName('Иван Петров'),
            new Email('ivan@testmail.ru'),
            new Body('Заявка в банк'),
            Lead::STATUS_NEW,
            null
        );

        if ($id !== null) {
            $this->setLeadId($lead, $id);
        }

        return $lead;
    }

    private function setLeadId(Lead $lead, int $id): void
    {
        $reflection = new ReflectionProperty(Lead::class, 'id');
        $reflection->setAccessible(true);
        $reflection->setValue($lead, $id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
