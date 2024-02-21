<?php

declare(strict_types=1);

namespace AlexanderGladkov\App\RequestChecking\Exceptions;

use AlexanderGladkov\App\Response\Response;
use Exception;

class RequestCheckingException extends Exception
{
    private Response $response;

    public function __construct(Response $response, $message = "", $code = 0, $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
