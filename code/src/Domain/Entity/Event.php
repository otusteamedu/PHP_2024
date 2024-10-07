<?php

declare(strict_types=1);

namespace Viking311\Queue\Domain\Entity;

use Viking311\Queue\Domain\ValueObject\Address;
use Viking311\Queue\Domain\ValueObject\Email;
use Viking311\Queue\Domain\ValueObject\EventDate;
use Viking311\Queue\Domain\ValueObject\Name;
use Viking311\Queue\Domain\ValueObject\NonZeroNumber;

class Event
{
    /**
     * @param Name $name
     * @param Email $email
     * @param EventDate $eventDate
     * @param Address $place
     * @param NonZeroNumber $guests
     */
    public function __construct(
        private readonly Name      $name,
        private readonly Email     $email,
        private readonly EventDate $eventDate,
        private readonly Address $place,
        private readonly NonZeroNumber $guests
    ){
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
}
