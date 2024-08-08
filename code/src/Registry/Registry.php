<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry;

use RuntimeException;
use Viking311\Analytics\Registry\Adapter\AdapterInterface;

class Registry
{
    const STORAGE_KEY = 'events';

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(private AdapterInterface $adapter)
    {
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->adapter->flush();
    }

    /**
     * @param EventEntity $event
     * @return void
     * @throws RuntimeException
     */
    public function addEvent(EventEntity $event): void
    {

        $success = $this->adapter->add(
            self::STORAGE_KEY,
            json_encode($event->getArray()),
            $event->priority
        );

        if (!$success) {
            throw new RuntimeException('Something wrong');
        }
    }

    /**
     * @param array $conditions
     * @return EventEntity|null
     */
    public function search(array $conditions): ?EventEntity
    {
        $res = $this->adapter->getByKey(
            self::STORAGE_KEY
        );

        foreach ($res as $event) {
            $found = true;
            foreach ($conditions as $paramName => $value) {
                if (!array_key_exists($paramName, $event->conditions) 
                    || $event->conditions[$paramName] !== $value
                ) {
                    $found = false;
                }        
            }

            if ($found) {
                return $event;
            }
        }  

        return null;
    }
}
