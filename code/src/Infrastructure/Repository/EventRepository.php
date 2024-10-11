<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Repository;

use Redis;
use RedisException;
use ReflectionProperty;
use Viking311\Api\Domain\Entity\Event;
use Viking311\Api\Domain\Repository\EventRepositoryInterface;
use Viking311\Api\Domain\ValueObject\Address;
use Viking311\Api\Domain\ValueObject\Email;
use Viking311\Api\Domain\ValueObject\EventDate;
use Viking311\Api\Domain\ValueObject\Name;
use Viking311\Api\Domain\ValueObject\NonZeroNumber;

class EventRepository implements EventRepositoryInterface
{
    const KEY_PREFIX = 'events';

    /**
     * @param Redis $redisClient
     */
    public function __construct(private Redis $redisClient)
    {
    }


    /**
     * @inheritDoc
     * @throws RedisException
     */
    public function getById(string $id): ?Event
    {
        $item = $this->redisClient->get(
            $this->getFullKey($id)
        );

        if (empty($item)) {
            return null;
        }

        $data = json_decode($item, true);

        return new Event(
            new Name($data['name'] ?? ''),
            new Email($data['email'] ?? ''),
            new EventDate($data['eventDate'] ?? ''),
            new Address($data['address'] ?? ''),
            new NonZeroNumber($data['guest'] ?? 0),
            $data['status'] ?? 'created',
            $data['id'] ?? null
        );
    }

    /**
     * @inheritDoc
     * @throws RedisException
     */
    public function save(Event $item): void
    {
        $id = $item->getId();
        if (is_null($id)) {
            $id = uniqid();
        }

        $json = json_encode([
            'id' => $id,
            'name' => $item->getName()->getValue(),
            'email' => $item->getEmail()->getValue(),
            'eventDate' => $item->getEventDate()->getValue()->format("Y-m-d H:i"),
            'address' => $item->getPlace()->getValue(),
            'guest' => $item->getGuests()->getValue(),
            'status' => $item->getStatus()
        ]);

        $this->redisClient->set(
            $this->getFullKey($id),
            $json
        );

        $reflectionProperty = new ReflectionProperty(Event::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($item, $id);
    }

    private function getFullKey(string $id): string
    {
        return self::KEY_PREFIX . '_' . $id;
    }
}
