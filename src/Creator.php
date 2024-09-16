<?php

declare(strict_types=1);

namespace hw15;

use hw15\mappers\EventMapper;
use hw15\mappers\ConditionMapper;
use hw15\adapters\RedisAdapter;
use hw15\services\EventServiceInterface;
use hw15\services\RedisEventService;
use hw15\helpers\SearchHelper;

class Creator
{
    private const SEARCH = 'search';
    private const DELETE = 'delete';
    private const INIT = 'init';

    private EventServiceInterface $eventService;

    public function __construct()
    {
        $this->eventService = new RedisEventService(
            new RedisAdapter(),
            new EventMapper(),
            new ConditionMapper(),
            new SearchHelper()
        );
    }

    /**
     * @return string
     */
    public function execute()
    {
        $method = $_SERVER["argv"][1] ?? '';
        $value = $_SERVER["argv"][2] ?? '';

        try {
            switch ($method) {
                case self::INIT:
                    return $this->eventService->init();
                case self::SEARCH:
                    return $this->eventService->search($value);
                case self::DELETE:
                    return $this->eventService->delete();
                default:
                    return $this->eventService->test();
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
