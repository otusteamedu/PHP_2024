<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Helpers\DTO;

use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotImplementException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ConstructorNotFoundException;
use ReflectionClass;
use ReflectionException;

class DTOBuilder
{
    /**
     * @param array $data
     * @param string $DTOClassName
     * @return DTOInterface
     * @throws ClassNotFoundException
     * @throws ClassNotImplementException
     * @throws ReflectionException
     * @throws ConstructorNotFoundException
     */
    public static function createFromArray(array $data, string $DTOClassName): DTOInterface
    {
        if (!class_exists($DTOClassName)) {
            throw new ClassNotFoundException($DTOClassName);
        }

        $subclass = DTOInterface::class;
        if (!is_subclass_of($DTOClassName, $subclass)) {
            throw new ClassNotImplementException($subclass);
        }

        $reflectionClass = new ReflectionClass($DTOClassName);
        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            throw new ConstructorNotFoundException($DTOClassName);
        }

        $params = [];
        foreach ($constructor->getParameters() as $param) {
            $paramName = $param->getName();
            $params[$paramName] = $data[$paramName] ?? null;
        }

        return $reflectionClass->newInstanceArgs($params);
    }
}
