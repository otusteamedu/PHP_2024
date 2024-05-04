<?php

namespace Ahar\Hw11;

use DomainException;

class ElasticConfig
{
    private string $host;
    private string $user;
    private string $password;

    public function __construct()
    {

        $host = getenv('ELASTIC_HOST');
        $user = getenv('ELASTIC_USER');
        $password = getenv('ELASTIC_PASSWORD');

        if (empty($host)) {
            throw new DomainException("host not sent");
        }

        if (empty($user)) {
            throw new DomainException("user not sent");
        }

        if (empty($password)) {
            throw new DomainException("password not sent");
        }
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
