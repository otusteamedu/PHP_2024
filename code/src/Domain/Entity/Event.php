<?php

declare(strict_types=1);

namespace Viking311\Api\Domain\Entity;

use Viking311\Api\Domain\ValueObject\Address;
use Viking311\Api\Domain\ValueObject\Email;
use Viking311\Api\Domain\ValueObject\EventDate;
use Viking311\Api\Domain\ValueObject\Name;
use Viking311\Api\Domain\ValueObject\NonZeroNumber;

class Event
{
    /** @var string|null  */
    private ?string $id = null;

    /**
     * @param Name $name
     * @param Email $email
     * @param EventDate $eventDate
     * @param Address $place
     * @param NonZeroNumber $guests
     */
    public function __construct(
        private Name $name,
        private Email $email,
        private EventDate $eventDate,
        private Address $place,
        private NonZeroNumber $guests,
        private string $status = 'created',
        ?string $id = null
    ) {
        if (!is_null($id)) {
            $this->id = $id;
        }
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return EventDate
     */
    public function getEventDate(): EventDate
    {
        return $this->eventDate;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return NonZeroNumber
     */
    public function getGuests(): NonZeroNumber
    {
        return $this->guests;
    }

    /**
     * @return Address
     */
    public function getPlace(): Address
    {
        return $this->place;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
