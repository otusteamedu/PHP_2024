<?php
require 'lib/model/YouTubeVideo.php';

$video = new YouTubeVideo(
    channelId: 'chanel2',
    videoId: 'video21',
    likes: 23,
    dislikes: 1
);
$dataForElastic = $video->toArrayForElastic();
$jsonPayload = json_encode($dataForElastic, JSON_PRETTY_PRINT);

$documentId = $video->videoId;
$url = "https://host.docker.internal:9200/youtube/_doc/" . $documentId;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonPayload)
]);
curl_setopt($ch, CURLOPT_USERPWD, 'elastic:R=v5CEpCxRJSvq+*eBTM');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Ошибка cURL: ' . curl_error($ch);
}
curl_close($ch);
print_r($response);
