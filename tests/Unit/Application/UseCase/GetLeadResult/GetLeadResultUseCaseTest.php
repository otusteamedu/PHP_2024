<?php

namespace Tests\Unit\Application\UseCase\GetLeadResult;

use App\Application\UseCase\GetLeadResult\GetLeadResultResponse;
use App\Application\UseCase\GetLeadResult\GetLeadResultUseCase;
use App\Domain\Entity\Lead;
use App\Domain\Repository\LeadRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetLeadResultUseCaseTest extends TestCase
{
    private LeadRepositoryInterface&MockObject $leadRepository;
    private GetLeadResultUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leadRepository = $this->createMock(LeadRepositoryInterface::class);
        $this->useCase = new GetLeadResultUseCase($this->leadRepository);
    }

    public function testInvokeReturnsResultResponse(): void
    {
        $leadId = 123;
        $expectedResult = '{"status":"success"}';

        $lead = $this->createMock(Lead::class);
        $lead->method('getResult')->willReturn($expectedResult);

        $this->leadRepository->expects($this->once())
            ->method('findById')
            ->with($leadId)
            ->willReturn($lead);

        $response = ($this->useCase)($leadId);

        $this->assertInstanceOf(GetLeadResultResponse::class, $response);
        $this->assertEquals($expectedResult, $response->result);
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
