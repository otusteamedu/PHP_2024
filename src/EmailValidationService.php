<?php

declare(strict_types=1);

namespace SFadeev\Hw6;

use SFadeev\Hw6\Validator\EmailDomainValidator;
use SFadeev\Hw6\Validator\EmailPatternValidator;

class EmailValidationService
{
    private ValidationService $validationService;

    public function __construct()
    {
        $this->validationService = new ValidationService([
            new EmailPatternValidator(),
            new EmailDomainValidator(),
        ]);
    }

    /**
     * @param string[] $emails
     * @return void
     */
    public function validateBatch(array $emails): void
    {
        foreach ($emails as $email) {
            $this->validate($email);
        }
    }

    /**
     * @param string $email
     * @return void
     */
    public function validate(string $email): void
    {
        $this->validationService->validate($email);
    }
}
