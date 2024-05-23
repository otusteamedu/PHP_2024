<?php

declare(strict_types=1);

namespace App\Application\UseCase\Form;

readonly class GenerateReportForm
{
    public function __construct(public array $ids)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->ids)) {
            throw new \InvalidArgumentException('IDs is required');
        }

        foreach ($this->ids as $id) {
            if (!is_int($id)) {
                throw new \InvalidArgumentException('All IDs must be integers');
            }
        }
    }
}
