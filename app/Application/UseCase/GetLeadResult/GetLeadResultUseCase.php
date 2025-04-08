<?php

namespace App\Application\UseCase\GetLeadResult;

use App\Domain\Repository\LeadRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if (null === $lead) {
            throw new NotFoundHttpException('Lead not found');
        }

        return new GetLeadResultResponse($lead->getResult());
    }


}
