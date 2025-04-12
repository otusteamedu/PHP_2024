<?php

namespace Tests\Unit\Application\UseCase\GetLeadStatus;

use App\Application\UseCase\GetLeadStatus\GetLeadStatusResponse;
use App\Application\UseCase\GetLeadStatus\GetLeadStatusUseCase;
use App\Domain\Entity\Lead;
use App\Domain\Repository\LeadRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetLeadStatusUseCaseTest extends TestCase
{
    private LeadRepositoryInterface&MockObject $leadRepository;
    private GetLeadStatusUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leadRepository = $this->createMock(LeadRepositoryInterface::class);
        $this->useCase = new GetLeadStatusUseCase($this->leadRepository);
    }

    public function testInvokeReturnsStatusResponse(): void
    {
        $leadId = 42;
        $expectedStatus = Lead::STATUS_QUEUED;

        $lead = $this->createMock(Lead::class);
        $lead->method('getStatus')->willReturn($expectedStatus);

        $this->leadRepository->expects($this->once())
            ->method('findById')
            ->with($leadId)
            ->willReturn($lead);

        $response = ($this->useCase)($leadId);

        $this->assertInstanceOf(GetLeadStatusResponse::class, $response);
        $this->assertEquals($expectedStatus, $response->status);
    }

    public function testInvokeThrowsNotFoundIfLeadMissing(): void
    {
        $leadId = 99999;

        $this->leadRepository->expects($this->once())
            ->method('findById')
            ->with($leadId)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Lead not found');

        ($this->useCase)($leadId);
    }
}
