<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Mapper\BaseMapper;
use Alogachev\Homework\DataMapper\Query\QueryItem;
use Alogachev\Homework\Exception\EmptyHallException;
use Alogachev\Homework\Exception\InvalidInputDataException;
use PDO;

class UpdateHall
{
    public function __construct(
        private readonly BaseMapper $hallMapper
    ) {
    }

    public function __invoke(array $data): void
    {
        $this->validate($data);
        $queryParam = new QueryItem(
            'id',
            PDO::PARAM_INT,
            (int)$data['id']
        );
        $hall = $this->hallMapper->finById($queryParam);

        if (!isset($hall)) {
            throw new EmptyHallException((int)$data['id']);
        }

        $hall
            ->setName($data['name'])
            ->setCapacity((int)$data['capacity'])
            ->setRowsCount((int)$data['rowsCount']);
        $this->hallMapper->update($hall);

        echo "Hall with id {$data['id']} updated" . PHP_EOL;
    }

    private function validate(array $data): void
    {
        if (!isset($data['id']) || !isset($data['name']) || !isset($data['capacity']) || !isset($data['rowsCount'])) {
            throw new InvalidInputDataException($data['action'] ?? '');
        }
    }
}
