<?php

require 'vendor/autoload.php';


echo "TEST\n";

$tbl = new Console_Table();


$tbl->setHeaders(array('Language', 'Year'));

$tbl->addRow(array('PHP', 1994));
$tbl->addRow(array('C',   1970));
$tbl->addRow(array('C++', 1983));

echo $tbl->getTable();
exit();

$client = \Elastic\Elasticsearch\ClientBuilder::create()
    ->setSSLVerification(false)
    ->setHosts([getenv('ES_HOST') . ':' . getenv('ES_PORT')])
    ->build();
//$resp = $client->index([
//    'index' => 'test',
//    'body' => [
//        'title' => 'test title',
//        'category' => 'test category',
//        'author' => [
//            'name' => 'test author name',
//            'email' => 'test author email'
//        ]
//    ],
//    'id' => 1
//]);

//var_dump($resp);

$res = $client->get(['index' => 'test', 'id' => '1']);

print_r($res->asArray());

