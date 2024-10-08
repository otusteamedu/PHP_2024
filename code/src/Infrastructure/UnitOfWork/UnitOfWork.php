<?php

declare(strict_types=1);


namespace Irayu\Hw0\Infrastructure\UnitOfWork;

// infrastructure/persistence/unitOfWork/UnitOfWork.php
class UnitOfWork {
    private $identityMap;
    private $newEntities = [];
    private $dirtyEntities = [];

    public function __construct(IdentityMap $identityMap) {
        $this->identityMap = $identityMap;
    }

    public function registerNew($entity) {
        $this->newEntities[] = $entity;
    }

    public function registerDirty($entity) {
        $this->dirtyEntities[] = $entity;
    }

    public function commit() {
        foreach ($this->newEntities as $entity) {
            // Persist new entities
            $this->identityMap->add($entity);
        }
        foreach ($this->dirtyEntities as $entity) {
            // Update existing entities
            $this->identityMap->update($entity);
        }
    }
}
