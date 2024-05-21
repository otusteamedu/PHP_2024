<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use ReflectionClass;

class PreFlushEventListener
{
    public function preFlush(PreFlushEventArgs $args): void
    {
//        dd('here');
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $entities = $unitOfWork->getScheduledEntityInsertions();
        $entities = array_merge($entities, $unitOfWork->getScheduledEntityUpdates());

        foreach ($entities as $entity) {
            $this->substituteCollections($entity);
        }
//        dd('FINISH');
    }

    private function substituteCollections(object $entity): void
    {
        $reflectionClass = new ReflectionClass($entity);
        foreach ($reflectionClass->getProperties() as $property) {
            $value = $property->getValue($entity);
//            dump($this->isCustomCollection($value));
            if ($this->isCustomCollection($value)) {
//                dump($value);
                $property->setValue(
                    $entity,
                    new ArrayCollection(is_array($value) ? $value : $value->toArray())
                );
            }
        }
//        dump($entity);
    }

    private function isCustomCollection(mixed $value): bool
    {
        return is_array($value) || (is_object($value) && method_exists($value, 'toArray'));
    }
}
