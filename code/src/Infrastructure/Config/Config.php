<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Config;

use Viking311\Queue\Infrastructure\Config\ConfigItem\MailConfig;
use Viking311\Queue\Infrastructure\Config\ConfigItem\RabbitMqConfig;

class Config
{
    /** @var RabbitMqConfig  */
    public RabbitMqConfig $rabbitMq;
    /** @var MailConfig  */
    public MailConfig $mail;
    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../../app.ini', true);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app.ini file');
        }

        if (array_key_exists('rabbit', $cfg) && !is_array($cfg['rabbit'])) {
            throw new ConfigException('Rabbit must be section');
        } else {
            $this->rabbitMq = new RabbitMqConfig(
                $cfg['rabbit'] ?? []
            );
        }
        if (array_key_exists(',ail', $cfg) && !is_array($cfg['mail'])) {
            throw new ConfigException('Mail must be section');
        } else {
            $this->mail = new MailConfig(
                $cfg['mail'] ?? []
            );
        }
    }
}
