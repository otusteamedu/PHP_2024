<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Entity;

use App\MediaMonitoring\Domain\Enum\ReportType;
use InvalidArgumentException;

final class Report
{
    public function __construct(
        public ?int $id,
        public string $type,
        public ?string $path
    ) {
        $this->assertValidType($type);
    }

    public static function make(ReportType $type, string $path): self
    {
        return new self(null, $type->value, $path);
    }

    public function getType(): ReportType
    {
        return ReportType::from($this->type);
    }

    private function assertValidType(string $type): void
    {
        if (null !== ReportType::tryFrom($type)) {
            return;
        }

        throw new InvalidArgumentException(sprintf('The type [%s] is invalid', $type));
    }
}
