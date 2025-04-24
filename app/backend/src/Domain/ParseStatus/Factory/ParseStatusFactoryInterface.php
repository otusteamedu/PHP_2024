<?php

namespace AnatolyShilyaev\Backend\Domain\ParseStatus\Factory;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Entity\ParseStatus;
use AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject\Status;

interface ParseStatusFactoryInterface
{
    public function create(
        Status $status,
    ): ParseStatus;
}
