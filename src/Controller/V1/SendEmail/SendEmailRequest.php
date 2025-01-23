<?php

declare(strict_types=1);

namespace App\Controller\V1\SendEmail;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SendEmailRequest
{
    public function __construct(
        #[Assert\Email]
        public string $from,

        #[Assert\Email]
        public string $to,

        #[Assert\NotBlank]
        public string $text,
    ) {}
}
