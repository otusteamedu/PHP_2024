<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

class Output
{
    private static function prepareTable($hits)
    {
        $arHeaders[] = [
            'title' => 'Title',
            'category' => 'Category',
            'price' => 'Price',
            'stock' => 'Stock'
        ];

        $arData = [];

        foreach ($hits as $hit) {
            $hitSource = $hit['_source'];
            $stock = [];
            foreach ($hitSource['stock'] as $oneStock) {
                $stock[] = $oneStock['shop'] . " - " . $oneStock['stock'] . " шт.";
            }
            $arData[] = [
                'title' => $hitSource['title'],
                'category' => $hitSource['category'],
                'price' => $hitSource['price'],
                'stock' => implode(", ", $stock)
            ];
        }

        $arTotal = $arHeaders + $arData;

        $columns = [];
        foreach ($arTotal as $row_key => $row) {
            foreach ($row as $cell_key => $cell) {
                $length = mb_strlen((string)$cell);
                if (empty($columns[$cell_key]) || $columns[$cell_key] < $length) {
                    $columns[$cell_key] = $length;
                }
            }
        }

        $table = '';
        foreach ($arTotal as $row_key => $row) {
            foreach ($row as $cell_key => $cell) {
                $table .= Helpers::myMbStrPad((string)$cell, $columns[$cell_key]) . '   ';
            }
            $table .= PHP_EOL;
        }
        return $table;
    }

    public static function renderTable($data)
    {
        if (empty($data['hits'])) {
            echo "Ничего не найдено" . PHP_EOL;
        } else {
            $result = self::prepareTable($data['hits']);
            echo $result;
        }
    }
}
