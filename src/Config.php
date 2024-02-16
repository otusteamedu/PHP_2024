<?php

namespace Ahor\Hw5;

class Config
{
    public string $socketFile;
    public int $maxLen;

    public function __construct(string $fileName)
    {
        $config = parse_ini_file($fileName, true);

        if (empty($config)) {
            throw new \DomainException("Файла конфига нету");
        }

        if (empty($config['socket']['file_name'])) {
            throw new \DomainException("Имя файла сокета не найден");
        }

        $this->socketFile = $config['socket']['file_name'];

        if (empty($config['socket']['max_len'])) {
            throw new \DomainException("Максимальная длинна не найдена");
        }

        $this->maxLen = (int)$config['socket']['max_len'];
    }
}
