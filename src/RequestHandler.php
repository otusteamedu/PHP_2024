<?php

declare(strict_types=1);

namespace App;

use App\BracketValidator;
use App\ResponseFormatter;

/**
 * RequestHandler class to handle incoming requests and validate brackets.
 */
class RequestHandler
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
     * Constructor for RequestHandler.
     *
     * @param BracketValidator $validator
     * @param ResponseFormatter $responseFormatter
     */
    public function __construct(BracketValidator $validator, ResponseFormatter $responseFormatter)
    {
        $this->validator = $validator;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * Handle the request and validate brackets.
     *
     * @return string
     */
    public function handle(): string
    {
        // Set CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("HTTP/1.1");

        try {
            // Check if request method is POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new BracketException("Method Not Allowed.", 405);
            }

            // Get data from POST request
            $string = $_POST['string'] ?? '';

            // Check if string is empty
            if (empty($string)) {
                throw new BracketException("String cannot be empty.", 400);
            }

            // Validate brackets
            if (!$this->validator->isBalanced($string)) {
                throw new BracketException("String is not balanced.", 400);
            }

            // Success response
            return $this->responseFormatter->sendSuccess(200, "All good!");

        } catch (BracketException $e) {
            return $this->responseFormatter->sendError($e->getCode(), $e->getMessage());
        }
    }
}
