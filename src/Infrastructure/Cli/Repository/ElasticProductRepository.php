<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Repository;

use App\Domain\Dto\SearchCondition;
use App\Domain\Entity\Product;
use App\Domain\Enum\ValueMatchingType;
use App\Domain\Repository\ProductRepositoryInterface;
use Elastic\Elasticsearch\ClientInterface;

readonly class ElasticProductRepository implements ProductRepositoryInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @param SearchCondition[] $params
     * @return Product[]
     */
    public function search(array $params): array
    {
        $searchConditions = [];
        $runtimeMappingFields = [];
        foreach ($params as $param) {
            if ($param->comparisonType === ValueMatchingType::EQUALS) {
                $fieldCondition = match ($param->field) {
                    'stock' => $param->field,
                    default => "{$param->field}.keyword",
                };
                $searchConditions[] = [
                    'match_phrase' => [
                        $fieldCondition => $param->value
                    ],
                ];
            } elseif ($param->comparisonType === ValueMatchingType::GREATER_THAN) {
                $searchConditions[] = [
                    'range' => [
                        $param->field => ['gte' => $param->value]
                    ],
                ];
            }  elseif ($param->comparisonType === ValueMatchingType::LESS_THAN) {
                $searchConditions[] = [
                    'range' => [
                        $param->field => ['lte' => $param->value]
                    ],
                ];
            }  elseif ($param->comparisonType === ValueMatchingType::ENTRY) {
                $searchConditions[] = [
                    'match' => [
                        $param->field => [
                            'query' => $param->value,
                            'fuzziness' => 'auto'
                        ]
                    ],
                ];
            }

            if ($param->field === 'stock') {
                $runtimeMappingFields[$param->field] = [
                    'type' => 'long',
                    'script' => [
                        'source' => "int sum = 0;for(s in doc['stock.stock']){sum += s;}emit(sum);"
                    ]
                ];
            }
        }

        $body = [
            'size' => 50,
            'query' => [
                'bool' => [
                    'must' => $searchConditions
                ]
            ]
        ];

        if ($runtimeMappingFields) {
            $runtimeMapping = [];
            foreach ($runtimeMappingFields as $field => $mapping) {
                $runtimeMapping[$field] = $mapping;
            }
            $body['runtime_mappings'] = $runtimeMapping;
        }

        $response = $this->client->search(['index' => 'otus-shop', 'body' => $body])->asArray();

        return array_map(
            static function (array $item) {
                $source = $item['_source'];
                $product = new Product(
                    $source['title'],
                    $source['category'],
                    $source['price'],
                    array_sum(array_column($source['stock'], 'stock'))
                );
                $reflectionProperty = new \ReflectionProperty(Product::class, 'id');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($product, $source['sku']);
                return $product;
            },
            $response['hits']['hits'] ?? []
        );
    }
}
