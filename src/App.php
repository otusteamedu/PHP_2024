<?php

declare(strict_types=1);

namespace App;

/**
 * Main application class
 */
class App
{
    /**
     * @var BracketValidator
     */
    private BracketValidator $validator;

    /**
     * @var ResponseFormatter
     */
    private ResponseFormatter $responseFormatter;

    /**
     * @var RequestHandler
     */
    private RequestHandler $requestHandler;

    /**
     * Initialize application components
     */
    public function __construct()
    {
        $this->validator = new BracketValidator();
        $this->responseFormatter = new ResponseFormatter();
        $this->requestHandler = new RequestHandler($this->validator, $this->responseFormatter);
    }

    /**
     * Run the application
     *
     * @return string Application output
     */
    public function run(): string
    {
        return $this->requestHandler->handle();
    }
}
