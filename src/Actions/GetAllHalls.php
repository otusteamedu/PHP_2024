<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Mapper\BaseMapper;
use ReflectionException;

class GetAllHalls
{
    public function __construct(
        private readonly BaseMapper $hallMapper
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function __invoke(): void
    {
        $halls = $this->hallMapper->findAll();

        echo json_encode(['halls' => array_map(
                static fn($hall) => $hall->toArray(),
                $halls
            )]) . PHP_EOL;
    }
}
