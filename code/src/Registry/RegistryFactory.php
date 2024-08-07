<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry;

use InvalidArgumentException;
use Viking311\Analytics\Config\Config;
use Viking311\Analytics\Registry\Adapter\RedisAdapterFactory;

class RegistryFactory {
    /**
     *
     * @return Registry
     * @throws InvalidArgumentException
     */
    public static function createInstance(): Registry
    {
        $config = new Config();
        if ($config->registryAdapter == 'redis') {
           $adapter = RedisAdapterFactory::getInstance();     
        } else {
            throw new InvalidArgumentException('Unknown adapter: ' . $config->registryAdapter);            
        }
        
        return new Registry($adapter);
    }
}
