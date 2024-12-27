<?php

namespace Naimushina\DataMapper;

use ArrayObject;
use SplObjectStorage;

class IdentityMap
{
    /**
     * @var ArrayObject
     */
    protected ArrayObject $idToObject;

    /**
     * @var SplObjectStorage
     */
    protected SplObjectStorage $objectToId;

    public function __construct()
    {
        $this->objectToId = new SplObjectStorage();
        $this->idToObject = new ArrayObject();
    }

    /**
     * @param integer $id
     * @param mixed $object
     */
    public function set(int $id, mixed $object): void
    {
        $this->idToObject[$id]     = $object;
        $this->objectToId[$object] = $id;
    }

    /**
     * @param mixed $object
     * @return int|null
     */
    public function getId(mixed $object): ?int
    {
        return $this->objectToId[$object] ?? null;
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function hasId(int $id): bool
    {
        return isset($this->idToObject[$id]);
    }

    /**
     * @param mixed $object
     * @return boolean
     */
    public function hasObject(mixed $object): bool
    {
        return isset($this->objectToId[$object]);
    }

    /**
     * @param integer $id
     * @return object|null
     */
    public function getObject($id): ?object
    {
        return $this->idToObject[$id] ?? null;
    }

}