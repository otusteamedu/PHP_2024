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
        /*
         if ($this->isIndexExists()) {
             //если индекс уже есть - подкючаемся
             $this->connect();
         } else {
             //если нет - создать и подключиться
             $this->createIndex();
             $this->connect();
         };
    }
        */

    public function isIndexExists()
    {
        $params = [
            'index' => $this->indexName,
            'body' => [
                'query' => [
                    'match' => [
                        "category" => "Детектив"
                    ]
                ]
            ]
        ];
        $this->client = ClientBuilder::create()
            ->setHosts(['http://$this->indexHost:9200'])
            ->build();
        $response = $this->client->search($params);
        $data = json_decode($response);
        if (isset($data->hits)) {
            return true;
        } else {
            return false;
        }
    }

    public function createIndex()
    {
        $params = array(
            "mappings" => array(
                "properties" => array(
                    "title" => array(
                        "type" => "text"
                    ),
                    "sku" => array(
                        "type" => "keyword"
                    ),
                    "category" => array(
                        "type" => "keyword"
                    ),
                    "price" => array(
                        "type" => "integer"
                    ),
                    "stock" => array(
                        "type" => "nested",
                        "properties" => array(
                            "shop" => array(
                                "type" => "keyword"
                            ),
                            "stock" => array(
                                "type" => "short"
                            )
                        )
                    )
                )
            ),
            "settings" => array(
                "analysis" => array(
                    "filter" => array(
                        "ru_stop" => array(
                            "type" => "stop",
                            "stopwords" => "_russian"
                        ),
                        "ru_stemmer" => array(
                            "type" => "stemmer",
                            "language" => "russian"
                        )
                    ),
                    "analyzer" => array(
                        "rebuilt_arabic" => array(
                            "tokenizer" => "standard",
                            "filter" => [
                                "lowercase",
                                "decimal_digit",
                                "arabic_stop",
                                "arabic_normalization",
                                "arabic_keywords",
                                "arabic_stemmer"
                            ]
                        )
                    )
                )
            )
        );
        //создать индекс
        $this->client->indices()->create($params);

        //згрузиь базу
        $json_file = __DIR__ . '/../books_db.json';
        $jsn = file_get_contents($json_file);
        $data = json_decode($jsn);
        $this->client->bulk(['body' => $data]);
    }

    public function connect()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://$this->indexHost:9200'])
            ->build();
    }

    public function search($query, $category, $maxPrice, $minStock)
    {

        $params = [
            "index" => $this->indexName,
            "body" => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "title" => [
                                        "query" => $query,
                                        "fuzziness" => 1
                                    ]
                                ]
                            ],
                            [
                                "match" => [
                                    "category" => $category
                                ]
                            ],
                        ],
                        "filter" => [
                            [
                                "range" => [
                                    "price" => [
                                        "lte" => $maxPrice
                                    ]
                                ]
                            ],

                            [
                                "range" => [
                                    "stock.stock" => [
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
