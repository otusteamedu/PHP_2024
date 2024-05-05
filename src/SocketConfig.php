<?php

declare(strict_types=1);

namespace JuliaZhigareva\OtusComposerPackage;

use DomainException;

 readonly class SocketConfig
{
     public string $socketPath;
     public int $maxLength;

     public function __construct()
     {
         $socketPath = getenv('SOCKET_PATH');
         $maxLength = getenv('MAX_LENGTH');

         if (empty($socketPath)) {
             throw new DomainException("SOCKET_PATH не найден");
         }

         if (empty($maxLength)) {
             throw new DomainException("MAX_LENGTH не найден");
         }

         $this->socketPath = $socketPath;
         $this->maxLength = (int)$maxLength;
     }
}
