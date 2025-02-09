<?php

declare(strict_types=1);

namespace Domain\Entities;

class Ticket
{
    public int $id;
    public int $show_id;
    public int $seat;
    public int $price;
    public int $available;
}
