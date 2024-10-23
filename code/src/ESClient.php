<?php

namespace Kyberlox\Elastic\ESClient;

require 'Elastic/vendor/autoload.php';
use Elastic\Elasticsearch\ClientBuilder as ClientBuilder;

class ESClient
{
    public $indexName;
    public $indexHost;
    public $client;

    public function __construct($indexName, $indexHost)
    {
        $this->indexName = $indexName;
        $this->indexHost = $indexHost;

        $this->connect();
    }

    public function connect()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://elastic:9200'])
            ->build();
    }

    public function search($query, $category, $maxPrice, $minStock)
    {

        $params = [
            "index" => $this->indexName,
            "body" =>[
                "query"=> [
                    "bool"=> [
                        "must"=> [
                            [
                                "match"=> [
                                    "title"=> [
                                        "query"=> $query,
                                        "fuzziness"=> 1
                                    ]
                                ]
                            ],
                            [
                                "match"=> [
                                    "category" => $category
                                ]
                            ],
                        ],
                        "filter"=> [
                            [
                                "range"=> [
                                    "price"=> [
                                        "lte"=> $maxPrice
                                    ]
                                ]
                            ],

                            [
                                "range"=> [
                                    "stock.stock"=> [
                                        "gte" => $minStock
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        return $response;
    }

}

//$clnt = new ESClient("otus-shop", "elastic");
//$res = $clnt->search("рыцОри", "Исторический роман", 2000, 1);
//print_r(json_decode($res));