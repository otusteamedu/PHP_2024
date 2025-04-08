<?php

namespace App\Application\UseCase\GetLeadStatus;

use App\Application\UseCase\GetLeadResult\GetLeadResultResponse;
use App\Domain\Repository\LeadRepositoryInterface;

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

        return new GetLeadStatusResponse($lead->getStatus());
    }


}
