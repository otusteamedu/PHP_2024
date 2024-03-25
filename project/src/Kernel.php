<?php

declare(strict_types=1);

namespace SFadeev\Hw12;

use Predis\Client;
use SFadeev\Hw12\Application\UseCase\ClearEventsUseCase;
use SFadeev\Hw12\Application\UseCase\FindRelevantEventUseCase;
use SFadeev\Hw12\Application\UseCase\SaveEventUseCase;
use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Exception\EventNotFoundException;
use SFadeev\Hw12\Domain\Service\ConditionService;
use SFadeev\Hw12\Domain\Service\EventService;
use SFadeev\Hw12\Infrastructure\Condition\Lexer;
use SFadeev\Hw12\Infrastructure\Condition\Parser;
use SFadeev\Hw12\Infrastructure\Redis\Config;
use SFadeev\Hw12\Infrastructure\Redis\EventRepository;

class Kernel
{
    private FindRelevantEventUseCase $findRelevantEventUseCase;
    private ClearEventsUseCase $clearEventsUseCase;
    private SaveEventUseCase $saveEventUseCase;

    public function __construct(
    ) {
        $projectDir = dirname(__DIR__);

        $redisConfig = Config::create($projectDir);

        $redisClient = new Client($redisConfig->toArray());
        $eventRepository = new EventRepository($redisClient);

        $lexer = new Lexer();
        $parser = new Parser($lexer);
        $conditionService = new ConditionService($parser);
        $eventService = new EventService($eventRepository, $conditionService);

        $this->findRelevantEventUseCase = new FindRelevantEventUseCase($eventService);
        $this->clearEventsUseCase = new ClearEventsUseCase($eventService);
        $this->saveEventUseCase = new SaveEventUseCase($eventService);
    }

    public function handle(array $args): void
    {
        switch ($args[1]) {
            case "save":
                $event = Event::fromJson($args[2]);
                $this->saveEventUseCase->handle($event);
                echo 'Event has been saved.' . PHP_EOL;
                break;
            case "clear":
                $this->clearEventsUseCase->handle();
                echo 'Event storage has been cleared.' . PHP_EOL;
                break;
            case "find":
                $params = json_decode($args[2], true, 512, JSON_THROW_ON_ERROR);
                try {
                    $event = $this->findRelevantEventUseCase->handle($params);
                    echo $event->getPayload() . PHP_EOL;
                } catch (EventNotFoundException) {
                    echo 'Event not found.' . PHP_EOL;
                }
                break;
        }
    }
}
