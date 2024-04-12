<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Mapper\BaseMapper;
use Alogachev\Homework\DataMapper\Query\QueryItem;
use PDO;

class GetHallById
{
    public function __construct(
        private readonly BaseMapper $hallMapper
    ) {
    }

    public function __invoke(array $data): void
    {
        $queryParam = new QueryItem(
            'id',
            PDO::PARAM_INT,
            (int)$data['id']
        );

        $hall = $this->hallMapper->finById($queryParam);

        echo json_encode($hall->toArray()) . PHP_EOL;
    }
}
