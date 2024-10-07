<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\Event;

use DateTimeImmutable;
use InvalidArgumentException;
use Viking311\Queue\Domain\Entity\Event;
use Viking311\Queue\Domain\Factory\EventFactoryInterface;
use Viking311\Queue\Domain\ValueObject\Address;
use Viking311\Queue\Domain\ValueObject\Email;
use Viking311\Queue\Domain\ValueObject\EventDate;
use Viking311\Queue\Domain\ValueObject\Name;
use Viking311\Queue\Domain\ValueObject\NonZeroNumber;

class EventFactory implements EventFactoryInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param DateTimeImmutable|string $eventDate
     * @param string $address
     * @param int $guest
     * @return Event
     * @throws InvalidArgumentException
     */
    public function create(
        string $name,
        string $email,
        DateTimeImmutable|string $eventDate,
        string $address,
        int $guest
    ): Event {
        $nameObject = new Name($name);
        $emailObject = new Email($email);
        $eventDateObject = new EventDate($eventDate);
        $place = new Address($address);
        $guestObject = new NonZeroNumber($guest);

        return new Event(
            $nameObject,
            $emailObject,
            $eventDateObject,
            $place,
            $guestObject
        );
    }
}
