<?php

namespace Otus\App\Elastic;

class Output
{
    private string $encoding = "UTF-8";
    private string $padString = " ";
    private int $padType = STR_PAD_RIGHT;

    /**
     * @param $input
     * @param $pad_length
     * @return mixed|string
     */
    private function mbStrPad($input, $pad_length): mixed
    {
        $input_length = mb_strlen($input, $this->encoding);
        $pad_length = $pad_length - $input_length;

        if ($pad_length > 0) {
            if ($this->padType == STR_PAD_RIGHT) {
                return $input . str_repeat($this->padString, $pad_length);
            } elseif ($this->padType == STR_PAD_LEFT) {
                return str_repeat($this->padString, $pad_length) . $input;
            } elseif ($this->padType == STR_PAD_BOTH) {
                $left = floor($pad_length / 2);
                $right = $pad_length - $left;
                return str_repeat($this->padString, $left) . $input . str_repeat($this->padString, $right);
            }
        }

        return $input;
    }

    /**
     * @param $document
     * @param $fields
     * @return void
     */
    private function extractFields($document, &$fields): void
    {
        foreach ($document as $key => $value) {
            if (is_array($value) && !isset($value[0])) {
                $this->extractFields($value, $fields[$key]);
            } else {
                $fields[$key] = true;
            }
        }
    }

    /**
     * @param $hits
     * @return array
     */
    private function getAllFieldNames($hits): array
    {
        $fields = [];

        foreach ($hits as $hit) {
            $this->extractFields($hit['_source'], $fields);
        }

        return array_keys($fields);
    }

    /**
     * @param $hit
     * @param $fieldName
     * @return false|mixed|string
     */
    private function getFieldValue($hit, $fieldName): mixed
    {
        $value = $hit['_source'][$fieldName] ?? '';

        if ($fieldName === 'stock' && is_array($value)) {
            $value = $this->formatStock($value);
        } elseif (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $value;
    }

    /**
     * @param $stockArray
     * @return string
     */
    private function formatStock($stockArray): string
    {
        $formattedStock = [];

        foreach ($stockArray as $stockItem) {
            if (isset($stockItem['shop']) && isset($stockItem['stock'])) {
                $formattedStock[] = "{$stockItem['shop']}: {$stockItem['stock']} шт";
            }
        }

        return implode(', ', $formattedStock);
    }

    /**
     * @param $hits
     * @return void
     */
    public function renderTable($hits): void
    {
        $fieldNames = $this->getAllFieldNames($hits);

        $maxLengths = [];

        foreach ($fieldNames as $fieldName) {
            $maxLengths[$fieldName] = mb_strlen($fieldName);
        }

        foreach ($hits as $hit) {
            foreach ($fieldNames as $fieldName) {
                $value = $this->getFieldValue($hit, $fieldName);
                $maxLengths[$fieldName] = max($maxLengths[$fieldName], mb_strlen((string)$value));
            }
        }

        // Header
        $table = "| ";
        foreach ($fieldNames as $fieldName) {
            $table .= $this->mbStrPad($fieldName, $maxLengths[$fieldName]) . " | ";
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
                $value = $this->getFieldValue($hit, $fieldName);
                $table .= $this->mbStrPad((string)$value, $maxLengths[$fieldName]) . " | ";
            }
            $table .= PHP_EOL;
        }

        print_r($table);
    }
}
