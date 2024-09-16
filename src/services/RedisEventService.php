<?php

declare(strict_types=1);

namespace hw15\services;

use hw15\adapters\StorageInterface;
use hw15\helpers\SearchHelper;
use hw15\mappers\ConditionMapper;
use hw15\mappers\EventMapper;

class RedisEventService implements EventServiceInterface
{
    public function __construct(
        private StorageInterface $storage,
        private EventMapper $eventMapper,
        private ConditionMapper $conditionMapper,
        private SearchHelper $searchHelper
    ) {
    }

    public function delete()
    {
        $this->storage->delete();

        return 'data deleted';
    }

    public function test()
    {
        return $this->storage->test();
    }

    public function search(string $value)
    {
        $eventsStorage = $this->storage->get();

        $events = array_map(function ($encodedEvent) {
            $event = json_decode($encodedEvent, true);
            return $this->eventMapper->dataToEntity($event);
        }, $eventsStorage);


        return $this->searchHelper->findByConditions(
            $this->conditionMapper->dataToEntity(json_decode($value, true)),
            $events
        );
    }

    public function init()
    {
        $analyticData = json_decode(file_get_contents(BASE_PATH . '/analytics.json'), true);

        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            throw new \Exception('No valid json');
        }

        foreach ($analyticData as $data) {
            if (!is_array($data)) {
                continue;
            }
            $this->storage->add($this->eventMapper->dataToEntity($data));
        }

        return 'data added successfully!';
    }
}
