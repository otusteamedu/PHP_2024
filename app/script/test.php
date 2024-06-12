<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$client = OpenAI::client('sk-image-generator-api-b7MXnzcV0YgtxfnDqi3zT3BlbkFJ5ZZYvp48ZHWjv8WCvqgF');

$response = $client->images()->create([
    'model' => 'dall-e-3',
    'prompt' => 'A cute baby sea otter',
    'n' => 1,
    'size' => '1024x1024',
    'response_format' => 'url',
]);

var_dump($response->toArray());