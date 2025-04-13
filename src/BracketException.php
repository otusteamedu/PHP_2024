<?php

declare(strict_types=1);

/**
 * BracketException class to handle exceptions related to bracket validation.
 */
class BracketException extends Exception
{
    /**
     * Constructor for BracketException.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
