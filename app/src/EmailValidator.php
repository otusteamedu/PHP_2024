<?php

declare(strict_types=1);

namespace Otus\Hw6;

class EmailValidator extends AbstractStringValidator
{
    /**
     * @param string|null $email
     * @return bool
     */
    public function validate(?string $email): bool
    {
        $this->checkEmail($email);
        return !$this->hasErrors();
    }

    /**
     * @param string $email
     * @return void
     */
    private function checkEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $this->addError("Email $email is not valid!");
        }
    }
}
