<?php

namespace App\Application\UseCase\GetLeadResult;

use App\Domain\Repository\LeadRepositoryInterface;

class GetLeadResultUseCase
{

    public function __construct(
        private LeadRepositoryInterface $leadRepository,
    )
    {
    }

    /**
     * @param int $leadId
     * @return GetLeadResultResponse|null
     */
    public function __invoke(int $leadId): ?GetLeadResultResponse
    {
        $lead = $this->leadRepository->findById($leadId);
//        if (null === $lead) {
//            return null;
//        }

        return new GetLeadResultResponse($lead->getResult());
    }


}
