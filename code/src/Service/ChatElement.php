<?php

namespace IraYu\Service;

use IraYu\Service;

abstract class ChatElement
{
    protected string $socketPath;
    protected mixed $output;

    public function __construct(string $socketPath)
    {
        $this->socketPath = $socketPath;
    }

    public function setOutputResource(mixed $output): static
    {
        if (is_resource($output)) {
            $this->output = $output;
        }

        return $this;
    }

    public function log(string $message): static
    {
        if (isset($this->output)) {
            $message = trim($message) . PHP_EOL;
            fwrite($this->output, $message, strlen($message));
        }

        return $this;
    }

    abstract public function start(): void;
}
