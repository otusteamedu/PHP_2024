<?php
declare(strict_types=1);

namespace App\ElasticSearch;


use Console_Table;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;


class Elasticsearch
{
    const HOST = 'elasticsearch:9200';
    const INDEX = "otus-shop";

    private function clientInit() {
        try {
            return ClientBuilder::create()
                ->setHosts([self::HOST])
                ->build();
        } catch (AuthenticationException $e) {
            echo $e->getMessage();
        }
    }

    //{
//  "title":"Кто подставил поручика Ржевского на Луне",
//  "sku":"500-000",
//  "category":"Исторический роман",
//  "price":3761,
//  "stock":[
//      {"shop":"Мира","stock":17},
//      {"shop":"Ленина","stock":1}
//  ]
//}


    # Request: index.php title='рыцОри' category='Исторические романы' price='0-2000'
    # 'title' => "рыцОри", 'category' => "Исторические романы", 'price' => array(0,2000)

    public function search(array $request)
    {
        $client = $this->clientInit();
        var_dump($request);

//        ["match"=> ["category" => $category]],
//        ["match"=> ["title" => $title]],
//        ["range" => ["price" => $price]],
//        ["range" => ["stock.stock" =>["gte"=>"1"]]]

        $terms = [];

        foreach ($request as $key => $value) {
            if (empty($value)) {
                $terms[$key] = [
                    'match_all' => (object)[]
                ];
            } else if ($key == 'category') {
                $terms[$key] = [
                    "match"=> [
                        "category" => [
                            "query" => $request['category'],
                            "fuzziness" => "2",
                            "operator" => "AND"
                        ]
                    ]
                ];
            } else if ($key == 'title') {
                $terms[$key] = [
                    "match"=> [
                        "title" =>[
                            "query" => $request['title'],
                            "fuzziness" => "2"
                        ]
                    ]
                ];
            } else if ($key == 'price') {
                $terms[$key] = [
                    "range" => [
                        "price" => [
                            "gte" => $request['price'][0],
                            "lte" => $request['price'][1]
                        ]
                    ]
                ];
            }
        }

        $stock = ["range" => ["stock.stock" =>["gte"=>"1"]]];

        $params = [
            "index" => self::INDEX,
            "body"  => [
                "query" => [
                    "bool" => [
                        "must" => [ $terms['category'], $terms['title'], $terms['price'], $stock ]
                    ]
                ],
            ]
        ];




        $response = $client->search($params);
        $response = $response['hits']['hits'];
        var_dump($response);
        $tbl = new Console_Table();
        $tbl->setHeaders(array('Название','Релевантность','Стоимость','Наличие'));

        foreach ($response as $item) {
            $tbl->addRow(array(
                $item['_source']['title'],
                $item['_score'],
                $item['_source']['price'].' RUB',
                'улица '.$item['_source']['stock'][0]['shop'].' - '.$item['_source']['stock'][0]['stock'].' , '
                .'улица '.$item['_source']['stock'][1]['shop'].' - '.$item['_source']['stock'][1]['stock']
            ));
        }

        echo $tbl->getTable();

    }

}