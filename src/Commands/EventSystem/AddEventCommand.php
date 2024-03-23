<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\EventSystem;

use DI\DependencyException;
use DI\NotFoundException;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Dto\EventSystem\EventObject;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;
use RailMukhametshin\Hw\Traits\ConditionParsableTrait;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddEventCommand extends AbstractCommand
{
    use ConditionParsableTrait;

    const PRIORITY_FIELD = 'priority';
    const CONDITIONS_FIELD = 'conditions';
    const EVENT_FIELD = 'event';

    const FIELDS = [
        self::PRIORITY_FIELD,
        self::EVENT_FIELD
    ];

    /**
     * @throws UnknownProperties
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function execute(): void
    {
        $repository = $this->container->get(EventRepositoryInterface::class);
        $repository->add($this->parseAndGetObject());
    }

    /**
     * @throws UnknownProperties
     */
    private function parseAndGetObject(): EventObject
    {
        $data = [];
        foreach ($this->argv as $condition) {
            $fieldValue = $this->parseCondition($condition);
            switch ($fieldValue->field) {
                case self::PRIORITY_FIELD:
                    $data[self::PRIORITY_FIELD] = $fieldValue->value;
                    break;
                case self::EVENT_FIELD:
                    $data[self::EVENT_FIELD]['name'] = $fieldValue->value;
                    break;
                default:
                    $data[self::CONDITIONS_FIELD][$fieldValue->field] = $fieldValue->value;
                    break;
            }
        }

        return new EventObject($data);
    }
}
