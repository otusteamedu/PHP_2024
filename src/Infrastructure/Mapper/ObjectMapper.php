<?php

declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Application\Mapper\IObjectMapper;
use IteratorAggregate;
use Symfony\Component\Serializer\SerializerInterface;

class ObjectMapper implements IObjectMapper
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function map(object $object, string $format): object|array
    {
        if ($object instanceof IteratorAggregate) {
            $result = [];
            foreach ($object as $item) {
                $result[] = $this->map($item, $format);
            }

            return $result;
        }

        return $this->serializer->deserialize(
            $this->serializer->serialize($object, 'json'),
            $format,
            'json'
        );
    }
}
