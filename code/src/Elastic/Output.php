<?php

namespace Otus\App\Elastic;

class Output
{
    private static function mb_str_pad($input, $pad_length, $pad_string = " ", $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8")
    {
        $input_length = mb_strlen($input, $encoding);
        $pad_length = $pad_length - $input_length;
        if ($pad_length > 0) {
            if ($pad_type == STR_PAD_RIGHT) {
                return $input . str_repeat($pad_string, $pad_length);
            } elseif ($pad_type == STR_PAD_LEFT) {
                return str_repeat($pad_string, $pad_length) . $input;
            } elseif ($pad_type == STR_PAD_BOTH) {
                $left = floor($pad_length / 2);
                $right = $pad_length - $left;
                return str_repeat($pad_string, $left) . $input . str_repeat($pad_string, $right);
            }
        }
        return $input;
    }

    private static function extractFields($document, &$fields)
    {
        foreach ($document as $key => $value) {
            if (is_array($value) && !isset($value[0])) {
                self::extractFields($value, $fields[$key]);
            } else {
                $fields[$key] = true;
            }
        }
    }

    private static function getAllFieldNames($hits)
    {
        $fields = [];

        foreach ($hits as $hit) {
            self::extractFields($hit['_source'], $fields);
        }

        return array_keys($fields);
    }

    private static function getFieldName($hit, $fieldName)
    {
        $value = isset($hit['_source'][$fieldName]) ? $hit['_source'][$fieldName] : '';
        if ($fieldName === 'stock' && is_array($value)) {
            $value = self::formatStock($value);
        } elseif (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return $value;
    }

    private static function formatStock($stockArray)
    {
        $formattedStock = [];
        foreach ($stockArray as $stockItem) {
            if (isset($stockItem['shop']) && isset($stockItem['stock'])) {
                $formattedStock[] = "{$stockItem['shop']}: {$stockItem['stock']} шт";
            }
        }
        return implode(', ', $formattedStock);
    }

    public static function renderTable($hits)
    {
        $fieldNames = self::getAllFieldNames($hits);

        $maxLengths = [];
        foreach ($fieldNames as $fieldName) {
            $maxLengths[$fieldName] = mb_strlen($fieldName);
        }
        foreach ($hits as $hit) {
            foreach ($fieldNames as $fieldName) {
                $value = self::getFieldName($hit, $fieldName);
                $maxLengths[$fieldName] = max($maxLengths[$fieldName], mb_strlen((string)$value));
            }
        }

        // Header
        $table = "| ";
        foreach ($fieldNames as $fieldName) {
            $table .= self::mb_str_pad($fieldName, $maxLengths[$fieldName]) . " | ";
        }
        $table .= PHP_EOL;

        // Divider
        $table .= "|";
        foreach ($fieldNames as $fieldName) {
            $table .= str_repeat('-', $maxLengths[$fieldName] + 2) . "|";
        }
        $table .= PHP_EOL;

        // Data
        foreach ($hits as $hit) {
            $table .= "| ";
            foreach ($fieldNames as $fieldName) {
                $value = self::getFieldName($hit, $fieldName);
                $table .= self::mb_str_pad((string)$value, $maxLengths[$fieldName]) . " | ";
            }
            $table .= PHP_EOL;
        }

        print_r($table);
    }
}
