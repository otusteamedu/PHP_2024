<?php

namespace Tests\Feature\Http\Controllers;

use App\Application\UseCase\AddLead\AddLeadResponse;
use App\Application\UseCase\AddLead\AddLeadUseCase;
use App\Application\UseCase\GetLeadResult\GetLeadResultResponse;
use App\Application\UseCase\GetLeadResult\GetLeadResultUseCase;
use App\Application\UseCase\GetLeadStatus\GetLeadStatusResponse;
use App\Application\UseCase\GetLeadStatus\GetLeadStatusUseCase;
use App\Domain\Entity\Lead;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use WithFaker;

    public function testAddLeadReturnsCreated(): void
    {
        $payload = [
            'userName' => 'Иван Петров',
            'email' => 'ivan@testmail.ru',
            'body' => 'Информация по заявке',
        ];

        $mockUseCase = $this->createMock(AddLeadUseCase::class);
        $mockUseCase->method('__invoke')
            ->willReturn(new AddLeadResponse(123));

        App::instance(AddLeadUseCase::class, $mockUseCase);

        $response = $this->postJson('/api/v1/leads/', $payload);

        $response->assertStatus(201)
            ->assertJson(['id' => 123]);
    }

    public function testGetLeadStatusReturnsStatus(): void
    {
        $leadId = 123;
        $mockUseCase = $this->createMock(GetLeadStatusUseCase::class);
        $mockUseCase->method('__invoke')
            ->with($leadId)
            ->willReturn(new GetLeadStatusResponse('queued'));

        App::instance(GetLeadStatusUseCase::class, $mockUseCase);

        $response = $this->getJson("/api/v1/leads/{$leadId}/status");

        $response->assertStatus(200)
            ->assertJson(['status' => Lead::STATUS_QUEUED]);
    }

    public function testGetLeadResultReturnsResult(): void
    {
        $leadId = 123;
        $expectedResult = [
            'sum' => 200,
            'status' => 'success',
            'message' => 'Заявка успешно обработана',
        ];

        $mockUseCase = $this->createMock(GetLeadResultUseCase::class);
        $mockUseCase->method('__invoke')
            ->with($leadId)
            ->willReturn(new GetLeadResultResponse(json_encode($expectedResult)));

        App::instance(GetLeadResultUseCase::class, $mockUseCase);

        $response = $this->getJson("/api/v1/leads/{$leadId}/result");

        $response->assertStatus(200)
            ->assertJson(['result' => $expectedResult]);
    }

    public function testAddLeadReturnsErrorOnException(): void
    {
        $mockUseCase = $this->createMock(AddLeadUseCase::class);
        $mockUseCase->method('__invoke')->willThrowException(new \Exception('Something went wrong'));

        App::instance(AddLeadUseCase::class, $mockUseCase);

        $response = $this->postJson('/api/v1/leads/', [
            'userName' => 'Иван Петров',
            'email' => 'ivan@testmail.ru',
            'body' => 'Ошибка выполнения заявки'
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure(['error']);
    }
}
