<?php

$indexName = 'youtube';
$channelId = 'chanel1';
$url = "https://host.docker.internal:9200/{$indexName}/_search";

$query = [
    'query' => [
        'term' => [
            'channelId.keyword' => $channelId
        ]
    ],
    'aggs' => [
        'total_likes' => [
            'sum' => [
                'field' => 'likes'
            ]
        ]
    ],
    'size' => 0
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
print_r($data);
$totalLikes = $data['aggregations']['total_likes']['value'] ?? 0;
echo "Всего лайков на канале {$channelId}: " . $totalLikes;
