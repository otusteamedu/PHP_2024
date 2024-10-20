<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Evgenyart\UnixSocketChat\Config;
use Evgenyart\UnixSocketChat\Exceptions\ConfigException;
use Test\Constants;

class ConfigTest extends TestCase
{
    private $config;

    protected function setUp(): void
    {
        $this->config = new Config();
        if (file_exists(Constants::TEST_CONFIG_PATH)) {
            unlink(Constants::TEST_CONFIG_PATH);
        }
    }

    public function testReturnConfig()
    {
        $this->assertNotEmpty($this->config::load());
    }

    public function testExceptionPath()
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage("No isset config.ini");
        $this->config::load(Constants::TEST_FAKE_CONFIG_PATH);
    }

    public function testExceptionNoIssetSocketPath()
    {
        file_put_contents(Constants::TEST_CONFIG_PATH, '');
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage("No isset socket_path in config.ini");
        $this->config::load(Constants::TEST_CONFIG_PATH);
    }

    public function testExceptionEmptySocketPath()
    {
        file_put_contents(Constants::TEST_CONFIG_PATH, 'socket_path = ');
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage("Empty value socket_path in config.ini");
        $this->config::load(Constants::TEST_CONFIG_PATH);
    }
}
