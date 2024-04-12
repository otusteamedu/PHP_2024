<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Entity\Hall;
use Alogachev\Homework\DataMapper\Mapper\BaseMapper;
use Alogachev\Homework\Exception\InvalidInputDataException;

class CreateHall
{
    public function __construct(
        private readonly BaseMapper $hallMapper
    ) {
    }

    public function __invoke(array $data): void
    {
        $this->validate($data);
        $hall = Hall::create($data['name'], (int)$data['capacity'], (int)$data['rowsCount']);
        $this->hallMapper->insert($hall);

        echo json_encode($hall->toArray()) . PHP_EOL;
    }

    private function validate(array $data): void
    {
        if (!isset($data['name']) || !isset($data['capacity']) || !isset($data['rowsCount'])) {
            throw new InvalidInputDataException($data['action'] ?? '');
        }
    }
}
