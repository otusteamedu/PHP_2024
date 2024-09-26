<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

use Exception;

class Filter
{
    public static function prepareFilter($params)
    {
        $queryArgs = [];

        for ($i = 1; $i < count($params); $i++) {
            if (preg_match('/^--([^=]+)=(.*)/', $params[$i], $match)) {
                $queryArgs[$match[1]] = $match[2];
            }
        }

        $result = self::buildFilter($queryArgs);

        return $result;
    }

    private static function buildFilter($queryArgs)
    {
        $elasticFilter = [];
        $must = [];     #login AND
        $should = [];   #login OR
        $filter = [];
        $stockFilter = [];
        $arAvParams = [
            'category',
            'query',
            'priceGTE',
            'priceGT',
            'priceLTE',
            'priceLT',
            'stockMinQuantity',
            'stockName'
        ];

        foreach ($queryArgs as $param => $value) {
            switch ($param) {
                case 'category':
                    $must[] = ['match' =>
                        [
                            'category' => [
                                "query"  => $value,
                                "fuzziness" => "auto"
                            ]
                        ]
                    ];
                    break;
                case 'query':
                    $must[] = [
                        'match' => [
                            "title" => [
                                "query" => $value,
                                "fuzziness" => "auto"
                            ]
                        ]
                    ];
                    break;
                case 'priceGTE':
                case 'priceGT':
                case 'priceLTE':
                case 'priceLT':
                    $filter[] = self::buildPriceFilter($param, $value);
                    break;
                case 'stockMinQuantity':
                case 'stockName':
                    $stockFilter[$param] = $value;
                    break;
                default:
                    throw new Exception("Параметр должен быть из списка: " . implode(", ", $arAvParams));
                    break;
            }
        }

        if (!empty($stockFilter)) {
            $must[] = self::buildStockFilter($stockFilter);
        }

        if (!empty($must)) {
            $elasticFilter['must'] = $must;
        }
       
        if (!empty($filter)) {
            $elasticFilter['filter'] = $filter;
        }

        return ['query' => ['bool' => $elasticFilter]];
    }

    private static function buildStockFilter($stockFilter)
    {
        $filter = [];
        $nestedFilte = [];

        if (isset($stockFilter['stockMinQuantity'])) {
            $filter[]["range"] =
                [
                    "stock.stock" => [
                        "gte" => $stockFilter['stockMinQuantity']
                    ]
                ];
        }

        if (isset($stockFilter['stockName'])) {
            $filter[]["match"] = [
                "stock.shop" => $stockFilter['stockName']
            ];
        }

        $nestedFilte = [
            "nested" => [
                "path" => "stock",
                "query" => [
                    "bool" => [
                        "filter" => $filter
                    ]
                ]
            ]
        ];

        return $nestedFilte;
    }

    #gte - Greater-than or equal to (>=)
    #lte - Less-than or equal to    (<=)
    #gt - Greater-than              (>)
    #lt - Less-than                 (<)
    private static function buildPriceFilter($operation, $value)
    {
        $arOperationParams = [
            'priceGTE' => 'gte',
            'priceGT' => 'gt',
            'priceLTE' => 'lte',
            'priceLT' => 'lt'
        ];

        $filter = [
            'range' => [
                "price" => [
                    $arOperationParams[$operation] => $value
                ]
            ]
        ];

        return $filter;
    }
}
