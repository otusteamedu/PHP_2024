<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\BankStatement;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineBankStatement;
use Symfony\Component\Serializer\SerializerInterface;

readonly class DoctrineBankStatementMapper
{

    public function __construct(
        protected SerializerInterface $serializer
    )
    {
    }

    public function toDoctrine(BankStatement $bankStatement): DoctrineBankStatement
    {
        $normalized = \array_filter($this->serializer->normalize($bankStatement));

        return $this->serializer->denormalize($normalized, DoctrineBankStatement::class);
    }

    public function fromDoctrine(DoctrineBankStatement $doctrineBankStatement): BankStatement
    {
        $normalized = \array_filter($this->serializer->normalize($doctrineBankStatement));

        return $this->serializer->denormalize($normalized, BankStatement::class);
    }
}
