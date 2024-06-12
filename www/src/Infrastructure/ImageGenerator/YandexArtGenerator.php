<?php

declare(strict_types=1);

namespace App\Infrastructure\ImageGenerator;

use GuzzleHttp\Client;

class YandexArtGenerator extends BaseImageGenerator
{
    private string $yandexFolderId;
    private string $yandexOAuthToken;
    private Client $client;
    private string $yandexIamToken;

    public function __construct(
        string $publicDirPath,
        string $imageDirPath,
        string $yandexFolderId,
        string $yandexOAuthToken,
    ) {
        parent::__construct($publicDirPath, $imageDirPath);
        $this->yandexFolderId = $yandexFolderId;
        $this->yandexOAuthToken = $yandexOAuthToken;
        $this->client = new Client();
    }


    /**
     * @param string $description
     * @return string путь до файла от корня проекта (/static/images/mock/example.png)
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateImage(string $description): string
    {
        $this->setIamToken();
        $id = $this->sendGenerationRequest($description);
        sleep(15);
        $filename = $this->saveImageToFolder($id);
        return $this->imageDirPath . '/' . $filename;
    }

    /**
     * Устанавливает токен для авторизации в сервисах Яндекс
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function setIamToken(): void
    {
        $response = $this->client->post('https://iam.api.cloud.yandex.net/iam/v1/tokens', [
            'json' => [
                'yandexPassportOauthToken' => $this->yandexOAuthToken
            ]
        ]);

        $this->yandexIamToken = json_decode((string)$response->getBody(), true)['iamToken'];
    }

    /**
     * Отправляет запрос на генерацию изображения
     * @param string $description
     * @return string идентификатор для последующего запроса картинки
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendGenerationRequest(string $description): string
    {
        $response = $this->client->post('https://llm.api.cloud.yandex.net/foundationModels/v1/imageGenerationAsync', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->yandexIamToken,
            ],
            'json' => [
                'modelUri' => "art://{$this->yandexFolderId}/yandex-art/latest",
                'generationOptions' => [
                    'seed' => 17
                ],
                'messages' => [
                    [
                        'weight' => 1,
                        'text' => $description
                    ]
                ]
            ]
        ]);

        $id = json_decode((string)$response->getBody(), true)['id'];
        echo "YandexART image id: " . $id . PHP_EOL;
        return $id;
    }

    /**
     * @param string $requestId
     * @return string имя сохраненной картинки
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function saveImageToFolder(string $requestId): string
    {
        $response = $this->client->get("https://llm.api.cloud.yandex.net:443/operations/$requestId", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->yandexIamToken,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        $encoded_data = $body['response']['image'];

        $img = str_replace('data:image/jpeg;base64,', '', $encoded_data);
        $data = base64_decode($img);
        echo "Got image data from YandexART: " . strlen($data) . PHP_EOL;
        $file_name = hash('md5', $data);
        $file = $file_name . '.png';
        echo "Save as $this->publicDirPath . $this->imageDirPath/$file" . PHP_EOL;
        file_put_contents($this->publicDirPath . $this->imageDirPath . "/$file", $data);

        return $file;
    }
}
