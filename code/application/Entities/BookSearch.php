<?php
declare(strict_types=1);

namespace App\Entities;

use App\ElasticSearch\Elasticsearch;
use App\Interfaces\SearchInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class BookSearch implements SearchInterface
{
    private Elasticsearch $elastic;
    private array $fields;
    public string $param_1 = 'category';
    public string $param_2 = 'title';
    public string $param_3 = 'price';

    #[Pure] public function __construct(array $fields) {
        $this->fields = $fields;
        $this->elastic = new Elasticsearch;
    }

    public function search(): array
    {

        $request = $this->validate();

        $terms = [];

        foreach ($request as $key => $value) {
            if (empty($value)) {
                $terms[$key] = [
                    'match_all' => (object)[]
                ];
            } else if ($key == $this->param_1) {
                $terms[$key] = [
                    "match"=> [
                        $this->param_1 => [
                            "query" => $request[$this->param_1],
                            "fuzziness" => "2",
                            "operator" => "AND"
                        ]
                    ]
                ];
            } else if ($key == $this->param_2) {
                $terms[$key] = [
                    "match"=> [
                        $this->param_2 =>[
                            "query" => $request[$this->param_2],
                            "fuzziness" => "2"
                        ]
                    ]
                ];
            } else if ($key == $this->param_3) {
                $terms[$key] = [
                    "range" => [
                        $this->param_3 => [
                            "gte" => $request[$this->param_3][0],
                            "lte" => $request[$this->param_3][1]
                        ]
                    ]
                ];
            }
        }

        $stock = ["range" => ["stock.stock" =>["gte"=>"1"]]];

        $params = [
            "index" => getenv("STORAGE_NAME"),
            "body"  => [
                "query" => [
                    "bool" => [
                        "must" => [ $terms[$this->param_1], $terms[$this->param_2], $terms[$this->param_3], $stock ]
                    ]
                ],
            ]
        ];

        $response = $this->elastic->search($params);

        $return = [];

        foreach ($response as $item) {

            $return[] = [
                $this->param_2 => $item['_source'][$this->param_2],
                'score' => $item['_score'],
                $this->param_3 => $item['_source'][$this->param_3].' RUB',
                'stock' => 'улица '.
                    $item['_source']['stock'][0]['shop'].' - '.
                    $item['_source']['stock'][0]['stock'].' , '.'улица '.
                    $item['_source']['stock'][1]['shop'].' - '.
                    $item['_source']['stock'][1]['stock']
            ];
        }

        return $return;
    }


    # Request: index.php title='рыцОри' category='Исторические романы' price='0-2000'
    #[ArrayShape(['title' => "string", 'category' => "string", 'price' => "array"])]
    private function validate(): array
    {
        $params = $this->fields;

        if (count($params) < 1) {
            echo "Usage: php index.php <param1> <param2>... <paramN>\n";
            exit(1);
        }

        $prepared = [
            $this->param_2 => '',
            $this->param_1 => '',
            $this->param_3 => []
        ];

        foreach ($params as $param) {

            $param = trim($param);
            $param = str_replace('  ',' ',$param);
            $explode = explode('=',$param);

            if ($explode[0] == $this->param_2) {
                $prepared[$this->param_2] = (string)$explode[1];
            }
            if ($explode[0] == $this->param_1) {
                $prepared[$this->param_1] = (string)$explode[1];
            }
            if ($explode[0] == $this->param_3) {
                $price = (string)$explode[1];
                $exp = explode('-',$price);
                $prepared[$this->param_3] = [$exp[0],$exp[1]];
            }
        }
        return $prepared;
    }

}