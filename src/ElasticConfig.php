<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

use DomainException;

readonly class ElasticConfig
{

    public string $host;
    public bool $sslVerification;
    public string $username;
    public string $password;

    public function __construct()
    {
        $host = getenv('ELASTICSEARCH_HOST');
        $sslVerification = getenv('ELASTICSEARCH_SSL_VERIFICATION');
        $username = getenv('ELASTICSEARCH_USERNAME');
        $password = getenv('ELASTICSEARCH_PASSWORD');


        if (empty($host)) {
            throw new DomainException("ELASTICSEARCH_HOST не найден");
        }

        if (empty($sslVerification)) {
            throw new DomainException("ELASTICSEARCH_SSL_VERIFICATION не найден");
        }

        if (empty($username)) {
            throw new DomainException("ELASTICSEARCH_USERNAME не найден");
        }

        if (empty($password)) {
            throw new DomainException("ELASTICSEARCH_PASSWORD не найден");
        }

        $this->host = $host;
        $this->sslVerification = $sslVerification === 'true';
        $this->username = $username;
        $this->password = $password;
    }

}