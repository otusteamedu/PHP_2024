<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Parser;

use App\Application\Parser\ConditionParserInterface;
use App\Domain\Dto\SearchCondition;
use App\Domain\Enum\ValueMatchingType;
use App\Domain\Exception\DomainException;

class ConditionParser implements ConditionParserInterface
{
    /**
     * @throws DomainException
     */
    public function parse(string $condition): SearchCondition
    {
        $condition = trim($condition);
        preg_match('~[=<>*]~', $condition, $matches);

        $sign = $matches[0] ?? '';
        $matchType = match ($sign) {
            '=' => ValueMatchingType::EQUALS,
            '<' => ValueMatchingType::LESS_THAN,
            '>' => ValueMatchingType::GREATER_THAN,
            '*' => ValueMatchingType::ENTRY,
            default => throw new DomainException('Invalid sign for condition: ' . $condition),
        };


        $args = array_map('trim', explode($sign, $condition));
        if (count($args) < 2) {
            throw new DomainException('Invalid condition: ' . $condition);
        }

        list($field, $value) = $args;

        $textFields = [
            'title',
            'category',
        ];
        $numericFields = [
            'price',
            'stock',
        ];

        $supportedFields = array_merge($textFields, $numericFields);
        if (!in_array($field, $supportedFields)) {
            throw new DomainException('Not supported field for condition: ' . $condition);
        }

        $textMatchingTypes = [ValueMatchingType::EQUALS, ValueMatchingType::ENTRY];
        if (in_array($field, $textFields) && !in_array($matchType, $textMatchingTypes)) {
            throw new DomainException('Invalid condition: ' . $condition);
        }

        return new SearchCondition($field, $value, $matchType);
    }
}