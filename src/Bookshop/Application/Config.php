<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application;

use AlexanderGladkov\Bookshop\Config\BaseConfig;
use AlexanderGladkov\Bookshop\Config\ConfigFileReadException;
use AlexanderGladkov\Bookshop\Config\ConfigValidationException;

class Config extends BaseConfig
{
    private readonly string $host;
    private readonly string $username;
    private readonly string $password;
    private readonly string $crtFilePath;
    private readonly string $indexDataFilePath;

    /**
     * @param $filename
     * @throws ConfigFileReadException
     * @throws ConfigValidationException
     */
    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->validate();
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCrtFilePath(): string
    {
        return $this->crtFilePath;
    }

    public function getIndexDataFilePath(): string
    {
        return $this->indexDataFilePath;
    }

    /**
     * @return void
     * @throws ConfigValidationException
     */
    private function validate(): void
    {
        $this->readSection('elasticsearch', [
            'host',
            'username',
            'password',
            'crt_file_path',
        ]);
        $this->readSection('data', ['index_data_file_path']);
    }
}
