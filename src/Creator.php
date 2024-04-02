<?php

declare(strict_types=1);

namespace hw15;

class Creator
{
    public function __construct(
        private StorageInterface $storage
    ) {
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
                case Dictionary::INIT:
                    $this->init();
                    break;
                case Dictionary::SEARCH:
                    return $this->search($value);
                case Dictionary::DELETE:
                    return $this->storage->delete();
                default:
                    return $this->storage->test();
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function search(string $value)
    {
        $eventsStorage = $this->storage->get();

        $events = array_map(function ($encodedEvent) {
            $event = json_decode($encodedEvent, true);

            var_dump($event);
            die;
            return new Event($event['priority'], $event['conditions'], $event['event']);
        }, $eventsStorage);

        var_dump($events);
        die;
    }

    private function init()
    {
        $analyticData = json_decode(file_get_contents(BASE_PATH . '/analytics.json'), true);

        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            throw new \Exception('No valid json');
        }

        foreach ($analyticData as $data) {
            $event = new Event(
                (int)($data["priority"] ?? 0),
                $data["conditions"] ?? [],
                $data["event"] ?? ''
            );

            $this->storage->add($event);
        }
    }
}
