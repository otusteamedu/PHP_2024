<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Config\ConfigItem;

class MailConfig
{
    /** @var string  */
    public string $host = 'localhost';
    /** @var int  */
    public  int $port = 25;
    /** @var string  */
    public string $user = '';
    /** @var string  */
    public string $password = '';
    /** @var string  */
    public string $fromEmail = '';
    /** @var string  */
    public string $fromName = '';

    public function __construct(array $cfg)
    {
        if (array_key_exists('host', $cfg)) {
            $this->host = $cfg['host'];
        }

        if (array_key_exists('port', $cfg)) {
            $this->port = (int) $cfg['port'];
        }

        if (array_key_exists('user', $cfg)) {
            $this->host = $cfg['user'];
        }

        if (array_key_exists('password', $cfg)) {
            $this->host = $cfg['password'];
        }

        if (array_key_exists('fromEmail', $cfg)) {
            $this->fromEmail = $cfg['fromEmail'];
        }

        if (array_key_exists('fromName', $cfg)) {
            $this->fromName = $cfg['fromName'];
        }
    }
}
