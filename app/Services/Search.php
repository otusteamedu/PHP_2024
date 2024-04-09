<?php

namespace App\Services;

use App\Contracts\ConnectorInterface;
use Exception;

readonly class Search
{
    public function __construct(private ConnectorInterface $connector)
    {
    }

    /**
     * @throws Exception
     */
    public function search(array $params): array
    {
        $events = $this->connector->getAll();

        if (empty($events)) {
            throw new Exception('Not found');
        }

        $events = array_filter($events, function ($event) use ($params) {
            if (empty($event['conditions'])) {
                return false;
            }

            $conditions = $event['conditions'];

            if (count($params) > count($conditions)) {
                return false;
            }

            foreach ($params as $key => $val) {
                if (!isset($conditions[$key]) || (int) $val !== (int) $conditions[$key]) {
                    return false;
                }
            }

            return true;
        });

        if (empty($events)) {
            throw new Exception('Not found');
        }

        usort($events, function ($a, $b) {
            if ((int)$a['priority'] < (int)$b['priority']) {
                return 1;
            }

            return -1;
        });

        return $events[0];
    }
}
