<?php

namespace Naimushina\Chat;

use Exception;

class ConfigManager
{
    private mixed $configs;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->configs = include('config.php');
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function get(string $key): mixed
    {
        $value = $this->configs[$key][0] ?: $this->configs[$key][1] ?: null;
        if(!$value){
            throw new Exception('ConfigManager Error: config not set for key '. $key );
        }
        return  $value;
    }

}
