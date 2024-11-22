<?php

namespace App\Controller\Validator;

use AllowDynamicProperties;
use App\Domain\ValueObject\Url;
use App\Infrastructure\Repository\NewsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[AllowDynamicProperties]
class UniqueUrlValidator extends ConstraintValidator
{
    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var UniqueUrl $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->repository->findByUrl(new Url($value))) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
