<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Exceptions;

/**
* те исключения, которые на требуют прерывания скрипта. Например, ситуация, когда сервер завершился, а клиент
 * продолажает работу. Сервер позже стартанет, и можно будет опять посылать сообщенрия.
 */
class RuntimeNotCriticalException extends RuntimeException
{
}
