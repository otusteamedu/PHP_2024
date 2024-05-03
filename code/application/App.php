<?php
declare(strict_types=1);

namespace App;


use App\Elasticsearch\Elasticsearch;
use JetBrains\PhpStorm\ArrayShape;

class App extends Elasticsearch
{
    public function run(array $argv): array
    {
        $params = $this->validate($argv);

        $elastic = new Elasticsearch();
        return $elastic->search($params);

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

    #[ArrayShape(['title' => "string", 'category' => "string", 'price' => "array"])]
    private function validate(array $params): array
    {
        if (count($params) < 1) {
            echo "Usage: php index.php <param1> <param2>... <paramN>\n";
            exit(1);
        }

        $prepared = [
            'title' => '',
            'category' => '',
            'price' => []
        ];

        foreach ($params as $param) {
            $explode = explode('=',$param);
            if ($explode[0] == 'title') {
                $prepared['title'] = (string)$explode[1];
            }
            if ($explode[0] == 'category') {
                $prepared['category'] = (string)$explode[1];
            }
            if ($explode[0] == 'price') {
                $price = (string)$explode[1];
                $exp = explode('-',$price);
                $prepared['price'] = [$exp[0],$exp[1]];
            }
        }

        return $prepared;
    }

}