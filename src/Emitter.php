<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Validator;

readonly class Emitter
{
    public function __construct(private Response $response)
    {
    }

    public function emit(): void
    {
        header('HTTP/1.0 ' . $this->response->getStatusCode() . ' ' . $this->response->getReasonPhrase());

        foreach ($this->response->getHeaders() as $name => $values) {
            header($name . ':' . implode(', ', $values));
        }

        echo json_encode([
            'success' => $this->response->isSuccess(),
            'message' => $this->response->getMessage(),
        ]);

        exit();
    }
}
