<?php

namespace Kyberlox\Elastic\index;

use Curl\Curl;

class Index
{
    public $link;

    public function __construct($indexName, $indexHost)
    {
        $this->link = "http://$indexHost:9200/$indexName";
        //проверка есть ли такой индекс
        if (! $this->isIndexExists()) {
            return true;
        } else {
            //если нет - создать
            if ($this->createIndex()) {
                return true;
            }
        }

        return false;
    }

    public function isIndexExists()
    {
        //проверка есть ли такой индекс
        $curl = curl_init("$this->link?pretty");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $answer = (curl_getinfo($curl, CURLINFO_HTTP_CODE));
        curl_close($curl);
        if ($answer == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function createIndex()
    {
        $data = array(
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
        $curl = curl_init($this->link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        curl_close($curl);

        //запушить json-файл
        $json_file = __DIR__ . '/../books_db.json';
        $data = file_get_contents($json_file);

        $curl = curl_init("$this->link/_bulk");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        curl_close($curl);

        return true;
    }
}

//$inx = new Index("otus-shop", "elastic");
