<?php

declare(strict_types=1);

namespace AlexanderGladkov\App\Response;

class Response
{
    private ?array $headers = null;

    /**
     * @param StatusCode $statusCode
     * @param string $message
     */
    private function __construct(private StatusCode $statusCode, private string $message)
    {
    }

    /**
     * @param array|null $headers
     * @return void
     */
    public function setHeaders(?array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->statusCode->value);
        if (!is_null($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }

        echo $this->message;
    }

    /**
     * @param string $message
     * @return static
     */
    public static function createSuccessResponse(string $message = 'Запрос успешно обработан'): static
    {
        return new static(StatusCode::OK, $message);
    }

    /**
     * @param string $message
     * @return static
     */
    public static function createBadRequestResponse(string $message = 'Произошла ошибка!'): static
    {
        return new static(StatusCode::BadRequest, $message);
    }

    /**
     * @param array $allowedRequestMethods
     * @param string $message
     * @return static
     */
    public static function createRequestMethodNotAllowedResponse(
        array $allowedRequestMethods,
        string $message = 'Неверный метод запроса!'
    ): static {
        $response = new static(StatusCode::RequestMethodNotAllowed, $message);
        $response->setHeaders(['Allow: ' . implode(', ', $allowedRequestMethods)]);
        return $response;
    }
}
