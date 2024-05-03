<?php
declare(strict_types=1);

namespace App\ElasticSearch;


use Console_Table;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use JetBrains\PhpStorm\ArrayShape;

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
        $params = [
            "index" => self::INDEX,
            "body"  => [
                "query" => [
                    "match" => [ "title" => $request['title']]
//                    "match" => [
//                        "content" => [
//                            "query" => $request['title'],
//                            "fuzziness" => "auto"
//
//                        ]
//
//                    ]
                ]
            ]
        ];




        $response = $client->search($params);
        $response = $response['hits']['hits'];
//        var_dump($response);
        $tbl = new Console_Table();

        $tbl->setHeaders(array('Название', 'Стоимость'));

        foreach ($response as $item) {
            $tbl->addRow(array(
                $item['_source']['title'],
                $item['_source']['price'].' RUB'
            ));
        }

        echo $tbl->getTable();

    }

}