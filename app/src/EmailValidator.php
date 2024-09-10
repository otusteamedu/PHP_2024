<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator;

final readonly class EmailValidator
{
    public function __construct(
        private ValidationPoolInterface $validationPool,
    ) {}

    /**
     * @param string[] $emails
     *
     * @return array{string, bool}
     */
    public function validateMany(array $emails): array
    {
        $result = [];

        foreach ($emails as $email) {
            $result[$email] = $this->validate($email);
        }

        return $result;
    }

    public function validate(string $email): bool
    {
        foreach ($this->validationPool->all() as $validation) {
            if ($validation->validate($email)) {
                continue;
            }

            return false;
        }

        return true;
    }
}
