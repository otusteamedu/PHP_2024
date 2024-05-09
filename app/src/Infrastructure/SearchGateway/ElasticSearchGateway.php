<?php

declare(strict_types=1);

namespace App\Infrastructure\SearchGateway;

use App\Domain\SearchGateway\SearchGatewayInterface;
use App\Domain\SearchGateway\Request\SearchGatewayRequest;
use App\Domain\SearchGateway\Response\SearchGatewayResponse;
use Elastic\Elasticsearch\ClientBuilder;

/**
 * Voiceflow AiGateway.
 */
class ElasticSearchGateway implements SearchGatewayInterface
{
    /**
     * Interact by text with AiGateway.
     */
    public function search(SearchGatewayRequest $request): SearchGatewayResponse
    {
        try {
            $client = ClientBuilder::create()
                ->setHosts([
                    getenv("ELASTIC_HOST")
                ])
                ->build();
            $result = $client->search([
                'index' => getenv("ELASTIC_INDEX"),
                'body' => $this->getQuery(
                    $request->query,
                    $request->gte,
                    $request->lte,
                    $request->category,
                    $request->shop
                ),
            ]);
            return new SearchGatewayResponse(
                $result['hits']['hits']
            );
        } catch (\Throwable $th) {
            throw new \Exception(
                $th->getMessage()
            );
        }
    }

    private function getQuery(
        string $query_string,
        int $gte = null,
        int $lte = null,
        string $category = null,
        string $shop = null
    ): array {
        $query = [
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];
        $nested = [
            'path' => 'stock',
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'stock.stock' => [
                                    'gte' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        if (isset($shop)) {
            $nested['query']['bool']['must'][] = [
                'term' => [
                    'stock.shop' => $shop,
                ],
            ];
        }
        $query['query']['bool']['must'][] = ['nested' => $nested];
        if (isset($query_string)) {
            $query['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $query_string,
                        'operator' => 'and',
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }
        if (isset($gte) || isset($lte)) {
            $range = [
                'range' => [
                    'price' => [],
                ],
            ];
            if (isset($gte)) {
                $range['range']['price']['gte'] = $gte;
            }
            if (isset($lte)) {
                $range['range']['price']['lte'] = $lte;
            }
            $query['query']['bool']['must'][] = $range;
        }
        if (isset($category)) {
            $query['query']['bool']['must'][] = [
                'term' => [
                    'category' => $category,
                ],
            ];
        }
        return $query;
    }
}
