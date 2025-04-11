<?php

namespace Tests\Unit\Application\UseCase\AddLead;

use App\Application\AsyncHandler\AsyncHandlerInterface;
use App\Application\AsyncHandler\LeadRequest;
use App\Application\UseCase\AddLead\AddLeadRequest;
use App\Application\UseCase\AddLead\AddLeadResponse;
use App\Application\UseCase\AddLead\AddLeadUseCase;
use App\Domain\Entity\Lead;
use App\Domain\Factory\LeadFactoryInterface;
use App\Domain\Repository\LeadRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AddLeadUseCaseTest extends TestCase
{
    private LeadRepositoryInterface&MockObject $leadRepository;
    private LeadFactoryInterface&MockObject $leadFactory;
    private AsyncHandlerInterface&MockObject $asyncHandler;
    private AddLeadUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leadRepository = $this->createMock(LeadRepositoryInterface::class);
        $this->leadFactory = $this->createMock(LeadFactoryInterface::class);
        $this->asyncHandler = $this->createMock(AsyncHandlerInterface::class);

        $this->useCase = new AddLeadUseCase(
            leadRepository: $this->leadRepository,
            leadFactory: $this->leadFactory,
            asyncHandler: $this->asyncHandler,
        );
    }

    public function testInvokeSuccessfullyCreatesAndProcessesLead(): void
    {
        $request = new AddLeadRequest(
            userName: 'Иван Петров',
            email: 'ivan@testmail.ru',
            body: 'Заявка в банк'
        );

        $lead = $this->createMock(Lead::class);

        $lead->method('getId')->willReturn(42);

        // Ожидаем вызов setStatus с Lead::STATUS_QUEUED
        $lead->expects($this->once())
            ->method('setStatus')
            ->with(Lead::STATUS_QUEUED);

        // Фабрика создает entity Lead
        $this->leadFactory->expects($this->once())
            ->method('create')
            ->with($request->userName, $request->email, $request->body)
            ->willReturn($lead);

        // Сохраняем
        $this->leadRepository->expects($this->once())
            ->method('save')
            ->with($lead);

        // Отправляем в очередь
        $this->asyncHandler->expects($this->once())
            ->method('sendRequest')
            ->with(new LeadRequest(42));

        // Обновляем
        $this->leadRepository->expects($this->once())
            ->method('update')
            ->with($lead);

        // Вызываем use case
        $response = ($this->useCase)($request);

        $this->assertInstanceOf(AddLeadResponse::class, $response);
        $this->assertEquals(42, $response->id);
    }
}
