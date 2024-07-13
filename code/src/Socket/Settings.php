<?php

namespace src\Socket;

use Exception;

class Settings
{
    public string $socketFilePath;
    public int $socketMessageMaxLength;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $socketFilePath = getenv('SOCKET_FILE_PATH');
        $socketMessageMaxLength = getenv('SOCKET_MESSAGE_MAX_LENGTH');

        if (empty($socketFilePath)) {
            throw new Exception('Empty SOCKET_FILE_PATH');
        }

        if (empty($socketMessageMaxLength)) {
            throw new Exception('Empty SOCKET_MESSAGE_MAX_LENGTH');
        }

        $this->socketFilePath = $socketFilePath;
        $this->socketMessageMaxLength = (int)$socketMessageMaxLength;
    }
}
