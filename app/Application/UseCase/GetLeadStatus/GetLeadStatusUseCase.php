<?php

namespace App\Application\UseCase\GetLeadStatus;

use App\Application\UseCase\GetLeadResult\GetLeadResultResponse;
use App\Domain\Repository\LeadRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetLeadStatusUseCase
{

    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository,
    )
    {
    }

    /**
     * @param int $leadId
     * @return GetLeadStatusResponse
     */
    public function __invoke(int $leadId): GetLeadStatusResponse
    {
        $lead = $this->leadRepository->findById($leadId);
        if (null === $lead) {
            throw new NotFoundHttpException('Lead not found');
        }

        return new GetLeadStatusResponse($lead->getStatus());
    }


}
