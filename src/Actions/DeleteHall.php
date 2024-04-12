<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Mapper\BaseMapper;
use Alogachev\Homework\DataMapper\Query\QueryItem;
use Alogachev\Homework\Exception\EmptyHallException;
use Alogachev\Homework\Exception\InvalidInputDataException;
use PDO;

class DeleteHall
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
        $this->hallMapper->delete($hall);

        echo "Hall with id {$data['id']} deleted" . PHP_EOL;
    }

    private function validate(array $data): void
    {
        if (!isset($data['id'])) {
            throw new InvalidInputDataException($data['action'] ?? '');
        }
    }
}
