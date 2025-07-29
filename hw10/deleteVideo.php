<?php
$documentId = 'video1';
$indexName = 'youtube';
$url = "https://host.docker.internal:9200/{$indexName}/_doc/{$documentId}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'elastic:R=v5CEpCxRJSvq+*eBTM');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Ошибка cURL: ' . curl_error($ch);
}
curl_close($ch);
print_r($response);
