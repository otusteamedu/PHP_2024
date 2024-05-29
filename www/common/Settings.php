<?php

declare(strict_types=1);

namespace Common;

readonly class Settings
{
    public string $rabbitmqUser;
    public string $rabbitmqPass;
    public string $rabbitmqHost;
    public int $rabbitmqPort;
    public string $rabbitmqQueueName;

    public string $smtpUser;
    public string $smtpPass;
    public string $smtpHost;
    public int $smtpPort;

    public function __construct(
        string $rabbitmqUser,
        string $rabbitmqPass,
        string $rabbitmqHost,
        int $rabbitmqPort,
        string $rabbitmqQueueName,
        string $smtpUser,
        string $smtpPass,
        string $smtpHost,
        int $smtpPort,
    ) {
        $this->rabbitmqUser = $rabbitmqUser;
        $this->rabbitmqHost = $rabbitmqHost;
        $this->rabbitmqPass = $rabbitmqPass;
        $this->rabbitmqPort = $rabbitmqPort;
        $this->rabbitmqQueueName = $rabbitmqQueueName;

        $this->smtpUser = $smtpUser;
        $this->smtpPass = $smtpPass;
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
    }

    public static function buildFromEnvVars(): static
    {
        return new Settings(
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASS'),
            getenv('RABBITMQ_HOST'),
            (int)getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_QUEUE'),
            getenv('SMTP_USER'),
            getenv('SMTP_PASS'),
            getenv('SMTP_SERVER'),
            (int)getenv('SMTP_PORT'),
        );
    }
}
