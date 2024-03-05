<?php

declare(strict_types=1);

namespace SFadeev\HW4;

class Response
{
    const PROTOCOL_VERSION = '1.1';

    /**
     * @param string|null $content
     * @param ResponseStatus $status
     * @param array $headers
     */
    public function __construct(
        private ?string $content = '',
        private ResponseStatus $status = ResponseStatus::HTTP_OK,
        private array $headers = []
    ) {
    }

    /**
     * @return void
     */
    public function send(): void
    {
        header(sprintf('HTTP/%s %s %s', self::PROTOCOL_VERSION, $this->status->value, $this->status->getText()), true, $this->status->value);

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value), true, $this->status->value);
        }

        echo $this->content;
    }
}
