<?php
$indexName = 'youtube';
$url = "https://host.docker.internal:9200/{$indexName}/_search";
$query = [
    'size' => 0,
    'aggs' => [
        'channels_by_ratio' => [
            'terms' => [
                'field' => 'channelId.keyword',
                'size' => 10,
                'order' => [
                    'like_dislike_ratio' => 'desc'
                ]
            ],
            'aggs' => [
                'total_likes' => [
                    'sum' => ['field' => 'likes']
                ],
                'total_dislikes' => [
                    'sum' => ['field' => 'dislikes']
                ],
                'like_dislike_ratio' => [
                    'bucket_script' => [
                        'buckets_path' => [
                            'likes' => 'total_likes.value',
                            'dislikes' => 'total_dislikes.value'
                        ],
                        'script' => 'params.likes / params.dislikes'
                    ]
                ]
            ]
        ]
    ]
];

$jsonPayload = json_encode($query);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_USERPWD, 'elastic:R=v5CEpCxRJSvq+*eBTM');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
var_dump($data);
