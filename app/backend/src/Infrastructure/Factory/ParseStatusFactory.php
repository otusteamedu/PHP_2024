<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Factory;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Factory\ParseStatusFactoryInterface;
use AnatolyShilyaev\Backend\Domain\ParseStatus\Entity\ParseStatus;
use AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject\Status;

class ParseStatusFactory implements ParseStatusFactoryInterface
{
    public function create(
        Status $status,
    ): ParseStatus {
        return new ParseStatus(
            $status,
        );
    }
}
