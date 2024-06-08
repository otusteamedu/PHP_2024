<?php


namespace Kagirova\Hw21\Domain\Exception;


use Throwable;

class InvalidArgumentException extends BaseException
{
    protected const GENERATED_STATUS = 500;
    protected const MESSAGE = "Некорректные настройки подключения к бд";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            InvalidArgumentException::MESSAGE,
            InvalidArgumentException::GENERATED_STATUS,
            $previous
        );
    }
}