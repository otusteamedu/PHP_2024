<?php

declare(strict_types=1);

namespace Viking311\Builder\Config;

class Config
{
    /** @var  string */
    public string $host;
    /** @var  integer */
    public int $port;
    /** @var  string */
    public string $dbName;
    /** @var  string */
    public string $user;
    /** @var  string */
    public string $password;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../app.ini', true);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app.ini file');
        }

        if (!array_key_exists('postgres', $cfg) || !is_array($cfg['postgres'])) {
            throw new ConfigException('Postgres section not found in app.ini file');
        }

        $postgresCfg = $cfg['postgres'];

        if (!array_key_exists('host', $postgresCfg)) {
            throw new ConfigException('host parameter not found in app.ini file');
        }
        $this->host = $postgresCfg['host'];

        if (array_key_exists('port', $postgresCfg)) {
            $this->port = (int)$postgresCfg['port'];
        } else {
            $this->port = 5432;
        }

        if (!array_key_exists('dbname', $postgresCfg)) {
            throw new ConfigException('dbname parameter not found in app.ini file');
        }
        $this->dbName = $postgresCfg['dbname'];

        if (!array_key_exists('user', $postgresCfg)) {
            throw new ConfigException('user parameter not found in app.ini file');
        }
        $this->user = $postgresCfg['user'];

        if (!array_key_exists('password', $postgresCfg)) {
            throw new ConfigException('password parameter not found in app.ini file');
        }
        $this->password = $postgresCfg['password'];
    }
}
