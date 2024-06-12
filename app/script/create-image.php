<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$token = 't1.9euelZrHismSioyYj8iXi4mTlZaRk-3rnpWaj5mMmczNzMiQxpfIkpuNzsjl8_d6QwlN-e9BY2sg_d3z9zpyBk3570FjayD9zef1656VmsyTlZHIkJHLkp3IypuKlp6K7_zF656VmsyTlZHIkJHLkp3IypuKlp6K.967o418iSvYpGCDrbONbZA0MV1_9b69XWls1PfHrZS6qn5LohCrGp962u4vlmky4uAtitl-ozSlJhaXXMal-Bw';
$folderId = 'b1gfq6ek86n8jsl09u7k';

$response = $client->post('https://llm.api.cloud.yandex.net/foundationModels/v1/imageGenerationAsync', [
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
    ],
    'json' => [
        'modelUri' => "art://$folderId/yandex-art/latest",
        'generationOptions' => [
            'seed' => 17
        ],
        'messages' => [
            [
                'weight' => 1,
                'text' => 'узор из цветных пастельных суккулентов разных сортов, hd full wallpaper, четкий фокус, множество сложных деталей, глубина кадра, вид сверху'
            ]
        ]
    ]
]);

echo $response->getBody();