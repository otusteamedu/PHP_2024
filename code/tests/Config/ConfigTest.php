<?php

declare(strict_types=1);

namespace Test\Config;

use Viking311\Chat\Config\Config;
use PHPUnit\Framework\TestCase;
use Viking311\Chat\Config\ConfigException;

class ConfigTest extends TestCase
{
    /** @var string  */
    private string $cfgPath = '/tmp/app.ini';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        if (file_exists($this->cfgPath)) {
            unlink($this->cfgPath);
        }
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCfgNotExists()
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage("File $this->cfgPath not exists");

        (new Config($this->cfgPath));
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCfgExistsWithoutSocketPathParam()
    {
        file_put_contents(
            $this->cfgPath,
            'parameter=value'
        );
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage('Socket path is not set');

        (new Config($this->cfgPath));
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCfgExistsSocketPathExists()
    {
        $value = 'testValue';
        file_put_contents(
            $this->cfgPath,
            "socket_path=$value"
        );

        $config = new Config($this->cfgPath);

        $this->assertEquals(
            $value,
            $config->socketPath
        );
    }

    /**
     * @return void
     */
    public function testReadCfgFromDefaultFile()
    {
        $config = new Config();
        $this->assertNotEmpty($config->socketPath);
    }
}
