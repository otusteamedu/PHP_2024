<?php
declare(strict_types=1);

namespace App\Storage;


use App\Storage\RedisStorage\RedisStorage;

class Storage implements StorageInterface
{
    private Object $storage;

    public function __construct() {
        # Change storage class
        $this->storage = new RedisStorage(getenv('REDIS_HOST'));
    }

    /**
     * @param array $arguments
     * @return bool
     * Command: docker exec -it fpm php /data/test.local/index.php addEvent 3000 'param1=1,param2=2' ::event:1:3
     */
    public function addEvent(array $arguments): bool|string
    {
       $params = [
            'priority' => 0,
            'conditions' => '',
            'event' => ''
        ];

        $params['priority'] = (int)$arguments[1];
        $params['conditions'] = (string)$arguments[2];
        $params['event'] = (string)$arguments[3];
        try {
            return $this->storage->addItem($params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return string
     * //docker exec -it fpm php /data/test.local/index.php deleteEvents
     */
    public function deleteEvents(): string
    {
        try {
            return $this->storage->deleteItems();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array $arguments
     * @return mixed
     * //docker exec -it fpm php /data/test.local/index.php getEvent 'param1=1'
     */
    public function getEvent(array $arguments): string
    {
        try {
            return $this->storage->getEvent($arguments);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}