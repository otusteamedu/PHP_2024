<?php

namespace Naimushina\EventManager;

class Event
{
    /**
     * @var int Важность события
     */
    public int $priority;
    /**
     * @var array Критерии его возникновения
     */
    public array $conditions;
    /**
     * Информация о событии
     * @var string
     */
    public string $data;

    /**
     * @param int $priority
     * @param array $conditions
     * @param string $data
     */
    public function __construct(int $priority, array $conditions, string $data)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->data = $data;
    }

    /**
     * Получаем информацию о событии в виде массива
     * @return array
     */
    public function getProperties(): array
    {
        $propertiesArray = get_object_vars($this);
        $propertiesArray['conditions'] = json_encode($this->conditions);
        return $propertiesArray;
    }
}
