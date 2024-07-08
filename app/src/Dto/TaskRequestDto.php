<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TaskRequestDto
{
    public function __construct(
        #[Assert\NotNull(message: 'The name must not be null')]
        #[Assert\NotBlank(message: 'The name must not be blank', allowNull: true)]
        public ?string $name = null,
        #[Assert\NotNull(message: 'The email must not be null')]
        #[Assert\NotBlank(message: 'The email must not be blank', allowNull: true)]
        #[Assert\Email(message: 'The email is not valid')]
        public ?string $email = null,
    ) {
    }

    public static function createFromParameters(array $parameters): self
    {
        return new self($parameters['name'] ?? null, $parameters['email'] ?? null);
    }
}
