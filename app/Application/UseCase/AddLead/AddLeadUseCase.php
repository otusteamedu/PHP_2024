<?php

namespace App\Application\UseCase\AddLead;

use App\Application\AsyncHandler\AsyncHandlerInterface;
use App\Application\AsyncHandler\LeadRequest;
use App\Domain\Factory\LeadFactoryInterface;
use App\Domain\Repository\LeadRepositoryInterface;

class AddLeadUseCase
{

    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository,
        private readonly LeadFactoryInterface $leadFactory,
        private readonly AsyncHandlerInterface $asyncHandler
    )
    {
    }

    /**
     * @param AddLeadRequest $request
     * @return AddLeadResponse
     */
    public function __invoke(AddLeadRequest $request): AddLeadResponse
    {
        // Создаем заявку
        $lead = $this->leadFactory->create($request->userName, $request->email, $request->body);

        // Сохраняем в БД
        $this->leadRepository->save($lead);

        // Отправляем в очередь на обработку
        $this->asyncHandler->sendRequest(
            new LeadRequest(
                $lead->getId(),
            )
        );

        return new AddLeadResponse($lead->getId());
    }

}
