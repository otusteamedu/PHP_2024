<?php

declare(strict_types=1);

namespace SFadeev\HW4;

use SFadeev\HW4\Validator\BracketSetValidator;
use SFadeev\HW4\Validator\InvalidBracketSetException;

class Kernel
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $value = $request->get('string');

        $validator = new BracketSetValidator();

        try {
            $validator->validate($value);
        } catch (InvalidBracketSetException $e) {
            $message = sprintf('Invalid input: %s.', $e->getMessage());
            return new Response($message, ResponseStatus::HTTP_BAD_REQUEST);
        }

        return new Response('Success.', ResponseStatus::HTTP_OK);
    }
}
