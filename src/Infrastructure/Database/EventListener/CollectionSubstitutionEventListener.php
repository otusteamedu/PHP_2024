<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class CollectionSubstitutionEventListener
{
    private array $domainCollections = [];

    public function preFlush(PreFlushEventArgs $args): void
    {
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $entities = $unitOfWork->getScheduledEntityInsertions();
        $entities = array_merge($entities, $unitOfWork->getScheduledEntityUpdates());

        foreach ($entities as $entity) {
            $this->substituteToDoctrineCollections($entity);
        }
    }

    /**
     * @throws ReflectionException
     */
    public function postFlush(PostFlushEventArgs $args): void
    {
        $this->substituteToInitialCollections();
    }

    private function substituteToDoctrineCollections(object $entity): void
    {
        $reflectionClass = new ReflectionClass($entity);
        foreach ($reflectionClass->getProperties() as $property) {
            $value = $property->getValue($entity);
            if ($this->isCustomCollection($value)) {
                $this->domainCollections[] = [$entity, $property->getName(), $value];
                $property->setValue(
                    $entity,
                    new ArrayCollection(is_array($value) ? $value : $value->toArray())
                );
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    private function substituteToInitialCollections(): void
    {
        foreach ($this->domainCollections as [$entity, $property, $originalCollection]) {
            $reflectionProperty = new ReflectionProperty($entity, $property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($entity, $originalCollection);
        }

        $this->domainCollections = [];
    }

    private function isCustomCollection(mixed $value): bool
    {
        return is_array($value) || (is_object($value) && method_exists($value, 'toArray'));
    }
}
