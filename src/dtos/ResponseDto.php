<?php

namespace dtos;

class ResponseDto
{
    public function __construct(
        private int $status,
        private string $message
    ) {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
