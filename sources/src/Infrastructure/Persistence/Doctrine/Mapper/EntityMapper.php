<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use Symfony\Component\Serializer\SerializerInterface;

abstract class EntityMapper
{
    protected string $doctrineClass;
    protected string $domainClass;

    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    public function toDoctrine(object $domainObject): object
    {
        $normalized = \array_filter($this->serializer->normalize($domainObject));

        return $this->serializer->denormalize($normalized, $this->doctrineClass);
    }

    public function fromDoctrine(object $doctrineObject): object
    {
        $normalized = \array_filter($this->serializer->normalize($doctrineObject));

        return $this->serializer->denormalize($normalized, $this->domainClass);
    }
}