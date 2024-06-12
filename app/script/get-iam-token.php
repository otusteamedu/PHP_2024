<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$response = $client->post('https://iam.api.cloud.yandex.net/iam/v1/tokens', [
    'json' => [
        'yandexPassportOauthToken' => 'y0_AgAAAABXZ1jQAATuwQAAAAEGg62AAACkLV8b02BKmYo6EXwIlcbXsbmo0w'
    ]
]);

$token = json_decode((string) $response->getBody(), true)['iamToken'];