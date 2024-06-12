<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';



$client = new \GuzzleHttp\Client();

$token = 't1.9euelZrHismSioyYj8iXi4mTlZaRk-3rnpWaj5mMmczNzMiQxpfIkpuNzsjl8_d6QwlN-e9BY2sg_d3z9zpyBk3570FjayD9zef1656VmsyTlZHIkJHLkp3IypuKlp6K7_zF656VmsyTlZHIkJHLkp3IypuKlp6K.967o418iSvYpGCDrbONbZA0MV1_9b69XWls1PfHrZS6qn5LohCrGp962u4vlmky4uAtitl-ozSlJhaXXMal-Bw';
$requestId = 'fbv9heict2rbum23k4rj';

$response = $client->get("https://llm.api.cloud.yandex.net:443/operations/$requestId", [
    'headers' => [
        'Authorization' => 'Bearer '. $token,
    ]
]);

$body = json_decode($response->getBody()->getContents(), true);
$encoded_data = $body['response']['image'];

$img          = str_replace('data:image/jpeg;base64,', '', $encoded_data );
$data         = base64_decode($img);
$file_name    = 'image_test';
$file         = $file_name . '.png';
$success      = file_put_contents($file, $data);