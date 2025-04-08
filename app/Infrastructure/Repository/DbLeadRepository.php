<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lead;
use App\Domain\Repository\LeadRepositoryInterface;
use App\Infrastructure\Factory\LeadFactory;
use ReflectionProperty;

class DbLeadRepository implements LeadRepositoryInterface
{

    public function __construct(
        private readonly LeadFactory $leadFactory
    )
    {
    }

    public function findById(int $id): ?Lead
    {
        $leadModel = \App\Infrastructure\Models\Lead::find($id);
        if (null === $leadModel) {
            return null;
        }

        $reflectionProperty = new ReflectionProperty(Lead::class, 'id');
        $reflectionProperty->setAccessible(true);
        $lead = $this->leadFactory->create(
            $leadModel->user_name,
            $leadModel->email,
            $leadModel->body,
            $leadModel->status,
            $leadModel->result,
        );
        $reflectionProperty->setValue($lead, $leadModel->id);

        return $lead;
    }

    public function save(Lead $lead): void
    {
        $leadModel = \App\Infrastructure\Models\Lead::query()
            ->create([
                         'user_name' => $lead->getUserName()->getValue(),
                         'email' => $lead->getEmail()->getValue(),
                         'body' => $lead->getBody()->getValue(),
                         'status' => $lead->getStatus(),
                         'result' => $lead->getResult(),
                     ]
            );

        $reflectionProperty = new ReflectionProperty(Lead::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($lead, $leadModel->id);
    }

    public function update(Lead $lead): void
    {
        $leadModel = \App\Infrastructure\Models\Lead::find($lead->getId());
        $leadModel->update([
                         'user_name' => $lead->getUserName()->getValue(),
                         'email' => $lead->getEmail()->getValue(),
                         'body' => $lead->getBody()->getValue(),
                         'status' => $lead->getStatus(),
                         'result' => $lead->getResult(),
                     ]
            );
    }
}
