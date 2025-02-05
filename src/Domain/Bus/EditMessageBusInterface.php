<?php

namespace App\Domain\Bus;

use App\Domain\DTO\Bus\EditMessageDTO;

interface EditMessageBusInterface
{
    public function editMessage(EditMessageDTO $editMessageDTO): bool;
}
