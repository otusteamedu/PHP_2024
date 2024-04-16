<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Elasticsearch;

use stdClass;

class QueryBuildHelper
{
    public function matchAll(): array
    {
        return ['match_all' => new stdClass()];
    }

    public function match(string $field, string $query, ?array $additionalParameters = null): array
    {
        $parameters = ['query' => $query];
        $parameters = $this->addAdditionalParameters($parameters, $additionalParameters);
        return ['match' => [$field => $parameters]];
    }

    public function matchFuzziness(string $field, string $query, int|string $fuzziness = 'auto'): array
    {
        return $this->match($field, $query, ['fuzziness' => $fuzziness]);
    }

    public function term(string $field, string $value, ?array $additionalParameters = null): array
    {
        $parameters = ['value' => $value];
        $parameters = $this->addAdditionalParameters($parameters, $additionalParameters);
        return ['term' => [$field => $parameters]];
    }

    public function range(string $field, array $parameters): array
    {
        return ['range' => [$field => $parameters]];
    }

    public function rangeGte(string $field, mixed $gteValue, ?array $additionalParameters = null): array
    {
        $parameters = ['gte' => $gteValue];
        $parameters = $this->addAdditionalParameters($parameters, $additionalParameters);
        return $this->range($field, $parameters);
    }

    public function rangeLte(string $field, mixed $lteValue, ?array $additionalParameters = null): array
    {
        $parameters = ['lte' => $lteValue];
        $parameters = $this->addAdditionalParameters($parameters, $additionalParameters);
        return $this->range($field, $parameters);
    }

    public function rangeGteLte(
        string $field,
        mixed $gteValue,
        mixed $lteValue,
        ?array $additionalParameters = null
    ): array {
        $parameters = ['gte' => $gteValue, 'lte' => $lteValue];
        $parameters = $this->addAdditionalParameters($parameters, $additionalParameters);
        return $this->range($field, $parameters);
    }

    public function nested(string $path, array $query): array
    {
        return ['nested' => ['path' => $path, 'query' => $query]];
    }

    private function addAdditionalParameters(array $parameters, ?array $additionalParameters): array
    {
        if ($additionalParameters === null || count($additionalParameters) === 0) {
            return $parameters;
        }

        return array_merge($parameters, $additionalParameters);
    }
}
